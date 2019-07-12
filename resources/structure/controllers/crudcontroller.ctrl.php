<?php
echo <<<EOF
<?php
/**
 * Controller $model
 *
 * @date $date
 * @sice $version
 */

/**
 * CRUD Controller para o modelo $model.
 *
 * @package Modules
 * @subpackage $model
 */
class {$model}Controller extends CrudController {
	/**
	 * Nome da model utilizada para o CRUD.
	 * @var string
	 */
	protected \$modelName = '$model';

	/**
	 * Título padrão para as views.
	 * @var string
	 */
	protected \$viewTitle = '$title';

	/**
	 * Número máximo de registros para exibir na listagem.
	 * @var int
	 */
	protected \$limit = 15;

	/**
	 * Campo padrão para ordenação.
	 * @var string
	 */
	protected \$sortField = '$sortField';

	/**
	 * Tipo de ordenação. Crescente ou decrescente.
	 * @var string
	 */
	protected \$sortOrder = 'ASC';

	/**
	 * Layout padrão para o módulo.
	 * @var string
	 */
	protected \$layoutName = 'default';

	/**
	 * Define o módulo cujo o controller pertence
	 * @var string
	 */

EOF;

echo '    public $module = ' . ($moduleGroup ? '\'' . $moduleGroup . '\'' : 'null') . ';' . "\n";

foreach ($fields as $field) {
    if ( $field['type'] == 'cropbox' ) {
        echo "\n\tprivate \$old" . $field['camelcase'] . "Name = null;\n";
    }
}

echo <<<EOF

	/**
	 * Mensagens de retorno para o usuário.
	 * @var array
	 */
	protected \$message = array (
		'error' => 'Um erro ocorreu ao tentar manipular o registro.',
		'created' => 'O registro foi adicionado com sucesso.',
		'updated' => 'O registro foi atualizado com sucesso.',
		'deleted' => 'O registro foi excluído com sucesso.',
		'allDeleted' => 'Todos os registros foram exluídos com sucesso.',
		'noRecordsSelected' => 'Nenhum registro foi selecionado.'
	);

	/**
	 * Construtor do CRUD
	 *
	 * @param string \$language Linguagem da requisição
	 */
	public function __construct( \$language = null )
    {
		parent::__construct( \$language );
	}

	/**
	 * Página de listagem de registro.
	 *
	 * Nesta página é feita a listagem dos registros da modelo deste controller.
	 *
	 * Este método sobreescreve o método index da classe CRUDController da framework.
	 *
	 * @param int \$page Página atual da listagem
	 * @param string \$sortField Campo para ordenação dos registros
	 * @param string \$sortOrder Maneira de ordenação ASC ou DESC
	 * @param int \$limit Número máximo de registros na listagem
	 * @param string|array \$filter Valor para filtagem dos registros
	 * @return object View - Retorna a view index.frm.php
	 */
	public function index( \$page = 1, \$sortField = false, \$sortOrder = false, \$limit = null, \$filter = null)
    {
		parent::index( \$page, \$sortField, \$sortOrder, \$limit, \$filter );
	}

	/**
	 * Obtem todos os registros da model.
	 *
	 * Retorna para a listagem todos os registros que devem aparecer.
	 * Sobrescreva este método, caso necessite de alguma forma específica de recuperar
	 * os registros.
	 *
	 * @param array \$filter Valor para filtagem dos registros
	 * @param string \$order Campo e maneira de ordenação dos registros
	 * @param int \$start Indica de qual resgistro começar a listar
	 * @param int \$limit Número máximo de registros na listagem
	 * @return array Lista de registros
	 */
	protected function getRecords( \$filter = array(), \$order = null, \$start = null, \$limit = null )
    {

EOF;
		
		foreach ($fields as $field) {
			if ( $field['name'] == 'deleted_at' ) {
				echo "\t\t\$filter[] = '`deleted_at` IS NULL';\n";
			}
		}
		
echo <<<EOF
		return parent::getRecords( \$filter, \$order, \$start, \$limit );
	}

	/**
	 * Retorna para a listagem o total de registros.
	 * Sobrescreva este método, caso necessite recuperar os registros de forma
	 * específica.
	 *
	 * @param array \$filter Valor para filtagem dos registros
	 * @return int Total de registros
	 */
	protected function getTotalRecords( \$filter = array() )
    {

EOF;
		
		foreach ($fields as $field) {
			if ( $field['name'] == 'deleted_at' ) {
				echo "\t\t\$filter[] = '`deleted_at` IS NULL';\n";
			}
		}
		
echo <<<EOF
		return parent::getTotalRecords( \$filter );
	}

	/**
	 * Realiza uma pesquisa na listagem de registros.
	 *
	 * Recebe os dados de pesquisa por parâmetro de requisição como POST, e realiza a
	 * pesquisa redirecionando para a index.
	 *
	 * Este método sobreescreve o existente na CRUDController para que seja
	 * tratado as peculiaridades da pesquisa.
	 *
	 * O método por padrão recebe a váriavel \$query como string para filtragem.
	 *
	 * @param string \$query String de pesquisa
	 * @return void
	 */
	public function search()
    {
		parent::search();
	}

	/**
	 * Vizualização de registro
	 *
	 * Monta a tela de visualização de registro. Este método passa para a view a
	 * variável "record" que pode ser acessada usando <code>\$this->record</code>
	 * em qualquer parte da view. A variável "record" é instanciada com base no id
	 * informado.
	 *
	 * Este método sobreescreve o existente na CRUDController para que seja
	 * tratado as peculiaridades da tela.
	 *
	 * @param int \$id Id do registro
	 * @return object View - Renderiza a view form.fm.php
	 */
	public function view( \$id )
    {
		parent::view( \$id );
	}

	/**
	 * Form para adição de um registro
	 *
	 * Monta a tela de adição de registro. Este método passa para a view a
	 * variável "record" que pode ser acessada usando <code>\$this->record</code>
	 * em qualquer parte da view. A variável "record" possui um valor nulo, pois não
	 * tem a necessidade de instanciar nenhum objeto para a adição.
	 *
	 * Este método sobreescreve o existente na CRUDController para que seja
	 * tratado as peculiaridades da tela.
	 *
	 * @return object View - Renderiza a view form.fm.php
	 */
	public function add()
    {
		parent::add();
	}

	/**
	 * Insere um novo registro.
	 *
	 * Este método insere no banco de dados o novo registro originado de um
	 * formulário.
	 *
	 * Este método sobreescreve o existente na CRUDController para que seja
	 * tratado as peculiaridades da inserção, porem é recomendado utilizar os métodos
	 * intermediários como "beforeCreate", "afterCreate", "afterCreateSave" e
	 * "afterSave".
	 *
	 * O novo registro será inserido capturando os campos no padrão
	 * {tabela}_{campo}, como por exemplo user_id ou user_password e populando os
	 * respectivos parâmetros referentes aos campos identificados.
	 *
	 * Ao final da inserção, será redirecionado para a action index deste controller.
	 *
	 * @return void
	 */
	public function create()
    {
		parent::create();
	}

	/**
	 * Form para edição de um registro
	 *
	 * Monta a tela de edição de registro. Este método passa para a view a
	 * variável "record" que pode ser acessada usando <code>\$this->record</code>
	 * em qualquer parte da view. A variável "record" é instanciada com base no id
	 * informado.
	 *
	 * Este método sobreescreve o existente na CRUDController para que seja
	 * tratado as peculiaridades da tela.
	 *
	 * @param int \$id Id do registro
	 * @return object View - Renderiza a view form.fm.php
	 */
	public function edit( \$id )
    {
		parent::edit( \$id );
	}

	/**
	 * Atualiza um registro.
	 *
	 * Este método atualiza no banco de dados o registro originado de um
	 * formulário.
	 *
	 * Este método sobreescreve o existente na CRUDController para que seja
	 * tratado as peculiaridades da inserção, porem é recomendado utilizar os métodos
	 * intermediários como "beforeUpdate", "afterUpdate", "afterUpdateSave" e
	 * "afterSave".
	 *
	 * O registro será atualizado capturando os campos no padrão
	 * {tabela}_{campo}, como por exemplo user_id ou user_password e populando os
	 * respectivos parâmetros referentes aos campos identificados.
	 *
	 * Ao final da inserção, será redirecionado para a action index deste controller.
	 *
	 * @return void
	 */
	public function update()
    {
		parent::update();
	}

	/**
	 * Remove um registro.
	 *
	 * Este método remove do banco de dados o registro indicado pelo \$id informado.
	 *
	 * Este método sobreescreve o existente na CRUDController para que seja
	 * tratado as peculiaridades da exclusão.
	 *
	 * Ao final da exclusão, será redirecionado para a action index deste controller.
	 *
	 * @return void
	 */
	public function delete( \$id )
    {
		parent::delete( \$id );
	}

	/**
	 * Executa ações antes da criação de um registro.
	 *
	 * Executa ações antes de preencher o novo registro com valores capturados do
	 * formulário.
	 *
	 * @param object \$object Objeto do processo
	 * @return void
	 */
	protected function beforeCreate( \$object )
    {

EOF;

foreach ($fields as $field) {
    if ( $field['type'] == 'cropbox' ) {
        echo "\t\t\$this->old" . $field['camelcase'] . "Name = \$object->" . $field['name'] . ";\n";
    }
}

echo <<<EOF
	}

	/**
	 * Executa ações após a criação de um registro.
	 *
	 * Executa ações após o novo registro ter sido preenchido com valores capturados
	 * do formulário.
	 *
	 * @param object \$object Objeto do processo
	 * @return void
	 */
	protected function afterCreate( \$object )
    {

EOF;

foreach ($fields as $field) {
	if ( $field['type'] == 'checkbox' ) {
		echo "\t\t\$object->" . $field['name'] . " = \$this->getHttpData('" . $field['id'] . "') ? '1' : '0';\n";
	}

	if ( $field['type'] == 'date' ) {
		echo "\t\t\$date = \$this->getHttpData( '" . $field['id'] . "' );";
		echo "\n\t\tif( \$date != '' ) {";
			echo "\n\t\t\t\$date = explode( '/', \$date );";
			echo "\n\t\t\t\$object->" . $field['id'] . " = date( 'Y-m-d', strtotime( \$date[2] . '-' . \$date[1] . '-' . \$date[0] ) );";
		echo "\n\t\t}\n";
	}

	if ( $field['type'] == 'datetime' ) {
		echo "\t\t\$date = \$this->getHttpData( '" . $field['id'] . "' );";
		echo "\n\t\tif( \$date != '' ) {";
			echo "\n\t\t\t\$date = explode( ' ', \$date );";
			echo "\n\t\t\t\$time = \$date[1]";
			echo "\n\t\t\t\$date = explode( '/', \$date[0] );";
			echo "\n\t\t\t\$object->" . $field['id'] . " = date( 'Y-m-d H:i:s', strtotime( \$date[2] . '-' . \$date[1] . '-' . \$date[0] . ' ' . \$time . ':00' ) );";
		echo "\n\t\t}\n";
	}
}

echo <<<EOF
	}

	/**
	 * Executa ações após efetivar a criação do registro.
	 *
	 * Executa ações após o novo registro ter sido salvo no banco de dados.
	 *
	 * @param object \$object Objeto do processo
	 * @return void
	 */
	protected function afterCreateSave( \$object )
    {
	}

	/**
	 * Executa ações antes da atualização do registo.
	 *
	 * Executa ações antes de preencher o registro com valores capturados do
	 * formulário.
	 *
	 * @param object \$object Objeto do processo
	 * @return void
	 */
	protected function beforeUpdate( \$object )
    {

EOF;

foreach ($fields as $field) {
    if ( $field['type'] == 'cropbox' ) {
        echo "\t\t\$this->old" . $field['camelcase'] . "Name = \$object->" . $field['name'] . ";\n";
    }
}

echo <<<EOF
	}

	/**
	 * Executa ações após a atualização do registo.
	 *
	 * Executa ações após o registro ter sido preenchido com valores capturados
	 * do formulário.
	 *
	 * @param object \$object Objeto do processo
	 * @return void
	 */
	protected function afterUpdate( \$object )
    {

EOF;

foreach ($fields as $field) {
	if ( $field['type'] == 'checkbox' ) {
		echo "\t\t\$object->" . $field['name'] . " = \$this->getHttpData('" . $field['id'] . "') ? '1' : '0';\n";
	}

	if ( $field['type'] == 'date' ) {
		echo "\t\t\$date = \$this->getHttpData( '" . $field['id'] . "' );";
		echo "\n\t\tif( \$date != '' ) {";
			echo "\n\t\t\t\$date = explode( '/', \$date );";
			echo "\n\t\t\t\$object->" . $field['name'] . " = date( 'Y-m-d', strtotime( \$date[2] . '-' . \$date[1] . '-' . \$date[0] ) );";
		echo "\n\t\t}\n";
	}

	if ( $field['type'] == 'datetime' ) {
		echo "\t\t\$date = \$this->getHttpData( '" . $field['id'] . "' );";
		echo "\n\t\tif( \$date != '' ) {";
			echo "\n\t\t\t\$date = explode( ' ', \$date );";
			echo "\n\t\t\t\$time = \$date[1]";
			echo "\n\t\t\t\$date = explode( '/', \$date[0] );";
			echo "\n\t\t\t\$object->" . $field['name'] . " = date( 'Y-m-d H:i:s', strtotime( \$date[2] . '-' . \$date[1] . '-' . \$date[0] . ' ' . \$time . ':00' ) );";
		echo "\n\t\t}\n";
	}
}

echo <<<EOF
	}

	/**
	 * Executa ações após efetivar a atualização do registro.
	 *
	 * Executa ações após o registro ter sido salvo no banco de dados.
	 *
	 * @param object \$object Objeto do processo
	 * @return void
	 */
	protected function afterUpdateSave( \$object )
    {
	}

	/**
	 * Executa ações após efetivar a criação ou atualização do registro.
	 *
	 * Executa ações após o registro ter sido salvo no banco de dados, seja durante
	 * a criação ou atualização.
	 *
	 * @param object \$object Objeto do processo
	 * @return void
	 */
	protected function afterSave( \$object )
    {

EOF;

foreach ($fields as $field) {
    if ( $field['type'] == 'cropbox' ) {
        echo "
        // Upload da imagem do cropbox para o campo \"" . $field['name'] . "\"
        \$photo = \$this->getHttpData('" . $field['id'] . "');
        \$photoData = \$this->getHttpData('" . $field['id'] . "_data');
        \$uri = substr(\$photoData, strpos(\$photoData, ',') + 1);
        if (\$photo['error'] === UPLOAD_ERR_OK) {
            \$path = \$object->get" . $field['camelcase'] . "DirUpload();
            \$oldFile = \$path . \$this->old" . $field['camelcase'] . "Name;

            if (file_exists(\$path) === false) {
                mkdir(\$path, 0775, true);
            }
            \$fileName = md5(time() . '" . $field['id'] . "') . '.jpg';
            file_put_contents(\$path . \$fileName, base64_decode(\$uri));
            \$object->" . $field['name'] . " = \$fileName;
            \$object->save();
            unlink(\$oldFile);
        }
        if (\$this->getHttpData('user_photo_remove') == '1') {
            \$path = \$object->get" . $field['camelcase'] . "DirUpload();
            unlink(\$path . \$this->old" . $field['camelcase'] . "Name);

            \$object->" . $field['name'] . " = null;
            \$object->save();
        }

        ";
	}

    if ( $field['type'] == 'file' ) {
        echo "\t\t\$file = \$_FILES['" . $field['id'] . "'];";
        echo "\n\t\tif (\$file['error'] === UPLOAD_ERR_OK) {";
            echo "\n\t\t\t\$ext = pathinfo(\$file['name'], PATHINFO_EXTENSION);";
            echo "\n\t\t\t\$fileName = md5(time() . '" . $field['id'] . "') . '.' . \$ext;";
            echo "\n\t\t\t\$path = \$object->get" . $field['camelcase'] . "DirUpload();";
            echo "\n\t\t\tif (file_exists(\$path) === false) {";
                echo "\n\t\t\t\tmkdir(\$path, 0775, true);";
            echo "\n\t\t\t}";
            echo "\n\t\t\tmove_uploaded_file(";
                echo "\n\t\t\t\t\$file['tmp_name'],";
                echo "\n\t\t\t\t\$path . \$fileName";
            echo "\n\t\t\t);";
            echo "\n\t\t\t\$object->" . $field['name'] . " = \$fileName;";
            echo "\n\t\t\t\$object->save();";
		echo "\n\t\t}\n\n";
    }
}

echo <<<EOF
	}

	/**
	 * Executa ações antes da exclusão do registo.
	 *
	 * Executa ações antes de excluir o registro do banco de dados.
	 *
	 * @param object \$object Objeto do processo
	 * @return void
	 */
	protected function beforeDelete( \$object )
    {
	}

	/**
	 * Executa ações após efetivar a exclusão do registro.
	 *
	 * Executa ações após o registro ter sido excluído no banco de dados.
	 *
	 * @param object \$object Objeto do processo
	 * @return void
	 */
	protected function afterDelete( \$object )
    {
	}

	/**
	 * Executa ações antes da exclusão de um registro.
	 *
	 * Executa ações antes de excluir um registro do banco de dados.
	 *
	 * Esta ação é executada para cada item a ser excluído.
	 *
	 * @param object \$object Objeto do processo
	 * @return void
	 */
	protected function beforeDeleteSelected( \$object )
    {
	}

	/**
	 * Executa ações após efetivar a exclusão de um registro.
	 *
	 * Executa ações após um registro ter sido excluído no banco de dados.
	 *
	 * Esta ação é executada para cada item a ser excluído.
	 *
	 * @param object \$object Objeto do processo
	 * @return void
	 */
	protected function afterDeleteSelected( \$object )
    {
	}
}

EOF;

