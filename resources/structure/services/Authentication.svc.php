<?php
/**
 *
 */
class Authentication {

	function __construct() {

	}

	public static function authenticate( $username, $password ) {
		// Busca o usuário pelo username
		$UserObj = new User();
		$return = $UserObj->find( array( 'username = "' . $username . '"' ) );

		// Verifica se foi encontrado
		if( $return > 0 ) {
			// Verifica se a senha está correta
			$UserObj = new User($return[0]['id']);
			$password = $UserObj->encyptPassword($password);
			if($return[0]['password'] == $password) {
 				Session::setVar('Native.User', $UserObj->id );
				return true;
			}
		}
		return false;
	}

	public static function isBlocked() {
		if( Session::getVar('Native.User') ) {
			$User = new User( Session::getVar('Native.User') );
			return $User->isBlocked();
		}
		return false;
	}

	public static function getAutheticateUser() {
		return new User( Session::getVar('Native.User') );
	}

	public static function isAthenticate() {
		if( Session::getVar('Native.User') ) {
			$User = new User( Session::getVar('Native.User') );
			if( $User->isBlocked() ) {
				Session::deleteVar('Native.User');
				return false;
			}
			return true;
		}
		return false;
	}

	public static function closeAuthentication() {
		Session::deleteVar('Native.User');
	}

	public static function hasPermission($nick) {
		return self::getAutheticateUser()->hasPermission($nick);
	}

	private static function registerAccessHistory() {

	}

	private static function updateAccessHsitory() {
		
	}
}
