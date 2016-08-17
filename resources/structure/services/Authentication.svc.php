<?php

/**
 *
 */
class Authentication
{
    /**
     * Tempo para a sessão expirar.
     */
    const INTERVAL_TO_DISCONNECT = '15 minute';

    /**
     * Tempo para expirar o cookie utilizado para manter a autenticação ativa.
     */
    const EXTEND_SESSION_DAYS = '30';

    /**
     * Armazena o obejeto do usuário autenticado, para evitar buscar
     * essa informação mais de uma vez no banco de dados.
     *
     * @var User
     */
    private static $user = false;

    /**
     * Armazena o registro de histórico de acesso do usuário autenticado para
     * atualizar e tempo ativo e permitir identificar outras sessões ativas.
     *
     * @var UserAccess
     */
    private static $userAccess = false;

    /**
     * Armazena os grupos que o usuário autenticado possui, para evitar buscar
     * essa informação mais de uma vez no banco de dados.
     *
     * @var UserGroup
     */
    private static $userGroup = array();

    /**
     * Realiza a autenticação.
     *
     * Busca no banco de dados pelo nome de usuário e senha, caso encontre
     * inicia a sessão.
     *
     * @param string $username Nome de usuário
     * @param string $password Senha de acesso
     * @return boolean Retorna true caso a autenticação seja realizada, caso
     * contrário retorna false.
     */
    public static function authenticate($username, $password)
    {
        $User = new User();
        $return = $User->find(array('username = "' . $username . '" OR email = "' . $username . '"'));

        if ($return > 0) {
            $User = new User($return[0]['id'], $return[0]);
            $password = $User->encyptPassword($password);

            if ($return[0]['password'] == $password) {
                Session::setVar('Auth.User', $User->id);
                self::$user = $User;
                self::registerAccessHistory();
                return true;
            }
        }
        return false;
    }

    /**
     * Autentica pela chave mestre do usuário.
     *
     * Este método permite efetuar a autenticação pela chave mestre do usuário.
     * Não é método seguro, portanto utilize sabiamente.
     *
     * @param string $keymaster Chave mestre do usuário
     * @return boolean Retorna true caso a autenticação seja realizada, caso
     * contrário retorna false.
     */
    public static function authenticateByKey($keymaster)
    {
        $User = new User();
        $return = $User->find(array('keymaster = "' . $keymaster . '"'));

        if ($return > 0) {
            $User = new User($return[0]['id'], $return[0]);
            Session::setVar('Auth.User', $User->id);
            self::$user = $User;
            self::registerAccessHistory();
            return true;
        }
        return false;
    }

    /**
     * Prolonga a autenticação mantando ativa por mais tempo.
     *
     * Prolonga a autenticação registrando um cookie na máquina do usuário.
     * O tempo para expirar é definido pela constante EXTEND_SESSION_DAYS.
     *
     * @return void
     */
    public static function extendSession()
    {
        // Obtem os dados da autenticação
        $AccessHistory = self::getAccessHistory();
        $User = self::getUser();

        // Array validador para gerar o token
        $cookieKey = array(
            'i' => $User->id,
            'k' => $User->keymaster,
            'a' => $AccessHistory->id,
            'v' => md5(
                $AccessHistory->id . '-' .
                $AccessHistory->user_agent . '-' .
                $AccessHistory->session_id . '-' .
                $User->id . '-' .
                $User->keymaster
            )
        );
        $token = json_encode($cookieKey);

        // Calcula o tempo de expiração da sessão.
        $lifetime = time() + self::EXTEND_SESSION_DAYS * 24 * 3600;

        // Obtém params de cookies atualizados.
        $cookieParams = session_get_cookie_params();
        // Define se existe conexão segura.
        $secure = isset($_SERVER["HTTPS"]);
        // Isso impede que o JavaScript possa acessar a identificação da sessão.
        $httponly = true;

        // Cria o cookie responsável por extender a sessão
        setcookie(
            session_name() . 'AUTH',
            $token,
            $lifetime,
            $cookieParams["path"],
            $cookieParams["domain"],
            $secure,
            $httponly
        );
        Session::setVar('Auth.ExtendedSession', true);
    }

    /**
     * Verifica se é a autenticação foi prolongada.
     *
     * @return boolean Retorna true caso tenha sido prolongada e false, caso
     * contrário
     */
    public static function isAnExtendedSession()
    {
        return Session::getVar('Auth.ExtendedSession') ? true : false;
    }

    /**
     * Verifica se a sessão foi extendida.
     *
     * Checa se a sessão foi extendida verificando a integridade dos dados.
     *
     * @return boolean Retorna true caso tenha sido extendida, e false caso
     * contrário.
     */
    public static function checkExtendedSession()
    {
        try {
            $tokenData = false;
            if (isset($_COOKIE[session_name() . 'AUTH'])) {
                $tokenData = json_decode($_COOKIE[session_name() . 'AUTH']);
            } else {
                return false;
            }

            $UserAccess = new UserAccess();
            $result = $UserAccess->findBy('id', $tokenData->a);
            if (count($result) == 0) {
                self::closeAuthentication();
                return false;
            }

            // Obtem os dados da autenticação
            $AccessHistory = new UserAccess($tokenData->a);
            $User = new User($tokenData->i);

            if ($tokenData->k != $User->keymaster) {
                return false;
            }

            // Obtem informações do Browser
            $Browser = new Browser();

            // Array validador para gerar o token
            $cookieKey = md5(
                $AccessHistory->id . '-' .
                $Browser->getUserAgent() . '-' .
                $AccessHistory->session_id . '-' .
                $User->id . '-' .
                $User->keymaster
            );

            if ($tokenData->v != $cookieKey) {
                self::closeAuthentication();
                return false;
            }

            $AccessHistory->forced_closure = '1';
            $AccessHistory->save();

            if (Session::getVar('Auth.User') == false) {
                Session::setVar('Auth.User', $User->id);
                Session::setVar('Auth.ExtendedSession', true);
                self::$user = $User;
                self::registerAccessHistory();
                return true;
            }
            return true;
        } catch (FwException $e) {
            self::closeAuthentication();
            return false;
        }
    }

    /**
     * Finaliza a sessão de autenticação.
     *
     * Finaliza a sessão de autenticação limpando inclusive os cookies para
     * prolongar sessão.
     *
     * @return void
     */
    public static function closeAuthentication()
    {
        $params = session_get_cookie_params();

        if (Session::getVar('Auth.UserAccess')) {
            $Access = self::getAccessHistory();
            $Access->forced_closure = '1';
            $Access->save();
        }

        $_SESSION = array();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
        setcookie(
            session_name() . 'AUTH',
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
        Session::deleteVar('Auth.User');
        Session::deleteVar('Auth.UserAccess');
        Session::destroy();
        Session::init();
        session_regenerate_id();
    }

    /**
     * Obtem o objeto com informações de usuário
     *
     * @return User
     */
    public static function getUser()
    {
        if (!self::$user) {
            if (Session::getVar('Auth.User')) {
                self::$user = new User(Session::getVar('Auth.User'));
            } else {
                return false;
            }
        }
        return self::$user;
    }

    /**
     * Verifica se existe autenticação ativa.
     *
     * @return boolean
     */
    public static function isAthenticate()
    {
        if (Session::getVar('Auth.User')) {
            $Access = self::getAccessHistory();
            if ($Access->forced_closure == '1') {
                self::closeAuthentication();
                return false;
            }
            return true;
        }
        return self::checkExtendedSession();
    }

    /**
     * Grava uma url para redirecionamento após efetuar autenticação.
     *
     * Este método permite que caso um usuário não esteja autentica, seja
     * redirecionado para a tela de login e depois de efetuar a autenticação,
     * volte para a URL de onde parou.
     *
     * @param type $url URL para redirecionamente pós autenticação.
     */
    public static function setRedirectUrl($url)
    {
        Session::setVar('Auth.RedirectUrl', $url);
    }

    /**
     * Remove a URL de redirecionamento pós autenticação.
     */
    public static function unsetRedirectUrl()
    {
        Session::deleteVar('Auth.RedirectUrl');
    }

    /**
     * Obtem a URL de redirecionamento pós autenticação.
     */
    public static function getRedirectUrl()
    {
        return Session::getVar('Auth.RedirectUrl');
    }

    /**
     * Verifica se o usuário está bloqueado.
     *
     * @return boolean
     */
    public static function isBlocked()
    {
        if (self::isAthenticate()) {
            $User = self::getUser();
            return $User->isBlocked();
        }
        return false;
    }

    /**
     * Obtem os grupos que o usuário autenticado possui.
     *
     * @return UserGroup[]
     */
    public static function getUserGroups()
    {
        if (self::isAthenticate()) {
            if (count(self::$userGroup) == 0) {
                $User = self::getUser();
                $userGroups = $User->getUserGroups();
                foreach ($userGroups as $UserGroup) {
                    self::$userGroup[$UserGroup->nick] = $UserGroup;
                }
            }
            return self::$userGroup;
        }
        return array();
    }

    /**
     * Verifica se um usuário tem um grupo específico.
     *
     * @param string $userGroup Nick para identificação do grupo
     * @return boolean
     */
    public static function inUserGroup($userGroup)
    {
        if (self::isAthenticate()) {
            $UserGroups = self::getUserGroups();
            return array_key_exists($userGroup, $UserGroups);
        }
        return false;
    }

    /**
     * Verifica se um usuário possui uma premissão especifica.
     *
     * @param string $nick Nick para identificação da permissão.
     * @return boolean
     */
    public static function hasPermission($nick)
    {
        if (self::isAthenticate()) {
            $User = self::getUser();
            return $User->hasPermission($nick);
        }
        return false;
    }

    /**
     * Obtem o registro de acesso ativo
     *
     * @return UserAccess
     */
    private static function getAccessHistory()
    {
        if (!self::$userAccess) {
            if (Session::getVar('Auth.UserAccess')) {
                $UserAccess = new UserAccess();
                $result = $UserAccess->findBy('id', Session::getVar('Auth.UserAccess'), array(), null, 0, 1);
                if (count($result) == 0) {
                    self::registerAccessHistory();
                } else {
                    self::$userAccess = new UserAccess($result[0]['id'], $result[0]);
                }
            } else {
                self::registerAccessHistory();
            }
        }
        $dateTimeValidation = strtotime(date('Y-m-d H:i:s') . ' -' . self::INTERVAL_TO_DISCONNECT);
        if (strtotime(self::$userAccess->updated_at) < $dateTimeValidation) {
            self::registerAccessHistory();
        }
        return self::$userAccess;
    }

    /**
     * Grava o registro de histórico de acesso.
     *
     * @throws FwException
     * @return void
     */
    private static function registerAccessHistory()
    {
        $Browser = new Browser();
        $User = self::getUser();
        $Access = new UserAccess();

        $sessionId = session_id();
        $result = $Access->find(array(
            '`session_id` = "' . $sessionId . '"',
            '`user_id` = "' . $User->id . '"',
            '`forced_closure` != "1"',
            '`updated_at` > DATE_SUB(now(), INTERVAL ' . self::INTERVAL_TO_DISCONNECT . ')'
            ));
        if (count($result) > 0) {
            $Access = new UserAccess($result[0]['id'], $result[0]);
            if (
                $Access->ip != $_SERVER['REMOTE_ADDR'] &&
                $Access->user_agent != $Browser->getUserAgent() &&
                $Access->browser_version != $Browser->getVersion() &&
                $Access->browser_version != $Browser->getVersion() &&
                $Access->plataform != $Browser->getPlatform()
            ) {
                throw new FwException(
                'Tentativa suspeita de acesso do usuário "' . $User->name .
                '" com id = "' . $User->id . '". O id da sessão "' .
                $sessionId . '" apresentou indícios de clonagem.'
                );
            }
        } else {
            $Access->ip = $_SERVER['REMOTE_ADDR'];
            $Access->user_agent = $Browser->getUserAgent();
            $Access->browser = $Browser->getBrowser();
            $Access->browser_version = $Browser->getVersion();
            $Access->plataform = $Browser->getPlatform();
            $Access->is_mobile = $Browser->isMobile() ? '1' : '0';
            $Access->is_tablet = $Browser->isTablet() ? '1' : '0';
            $Access->is_robot = $Browser->isRobot() ? '1' : '0';
            $Access->session_id = session_id();
            $Access->time = "1";
            $Access->forced_closure = '0';
            $Access->user_id = $User->id;
            $Access->updated_at = date('Y-m-d H:i:s');
            $Access->save();
        }

        Session::setVar('Auth.UserAccess', $Access->id);

        self::$userAccess = $Access;
    }

    /**
     * Obtem outras sessões ativas do mesmo usuário.
     *
     * @return UserAccess[]
     */
    public static function getOtherActiveSessions()
    {
        $User = self::getUser();
        $Access = self::getAccessHistory();

        $result = $Access->find(
            array(
                '`user_id` = "' . $User->id . '"',
                '`id` != "' . $Access->id . '"',
                '`updated_at` > DATE_SUB(now(), INTERVAL ' . self::INTERVAL_TO_DISCONNECT . ')',
                '`forced_closure` != "1"'
            ),
            '`updated_at` DESC'
        );

        return $result;
    }

    /**
     * Verifica se existe mais de uma sessão ativa do usuário ativo.
     *
     * @return boolean
     */
    public static function hasOtherActiveSessions()
    {
        $result = self::getOtherActiveSessions();
        return is_array($result) && count($result) > 0;
    }

    /**
     * Finaliza outras sessão ativas do usuário que não seja a atual.
     *
     * @return boolean
     */
    public static function closeOtherActiveSessions()
    {
        $result = self::getOtherActiveSessions();
        if (is_array($result) && count($result) > 0) {
            foreach ($result as $access) {
                $Access = new UserAccess($access['id'], $access);
                $Access->forced_closure = '1';
                $Access->save();
            }
        }
        return true;
    }

    /**
     * Atualiza o registro de histórico de acesso ativo.
     * 
     * @return void
     */
    public static function updateAccessHistory()
    {
        $Access = self::getAccessHistory();

        $lastActivity = $Access->updated_at ? strtotime($Access->updated_at) : time();
        $Access->time = $Access->time + ( time() - $lastActivity );
        $Access->save();

        self::$userAccess = $Access;
    }
}
