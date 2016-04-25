<?php
/**
 * [en]
 * 
 * [pt-br]
 * Classe responsável em realizar o backup dos dados do sistema. A classe não será 
 * responsável pelo backup dos arquivos do sistema, somente os dados do banco de 
 * dados e dos arquivos de conteúdo do cliente.
 * 
 * @author Marcus Alexandre Gomes Maia ( contato@marcusmaia.com.br )
 * @copyright Copyright 2009 (c) marcusmaia.com.br
 * @package Framework
 * @subpackage System
 * @category Types
 * @version 0.1
 */
class Backup {
	/**
	 * Nome gerado automaticamente para facilitar a identificação dos arquivos de 
	 * backup
	 *
	 * @var string
	 */
	private $_backupName;
	
	/**
	 * Nome do arquivo SQL que é gerado para ser adicionado no arquivo de backup e é 
	 * salvo temporariamente na pasta raiz.
	 * 
	 * @var string
	 */
	private $_databaseDumpName;
	
	/**
	 * Pasta temporária onde serão salvos arquivos para serem manipulados durante o 
	 * backup e onde fecará o arquivo caso não seja para salvar no servidor.
	 *
	 * @var string
	 */
	private $_pathTemp;
	
	/**
	 * Pasta onde será salvo o arquivo de backup.
	 * 
	 * @var string
	 */
	private $_pathToSave;
	
	/**
	 * Flag que indica se o sistema deverá salvar o arquivo no servidor depois de 
	 * concluir a geração do backup.
	 *
	 * @var bool
	 */
	private $_saveToDisk = true;
	
	/**
	 * Lista de pastas que serão incluídas no backup. Cada item deve conter
	 * o caminho completo da pasta
	 * 
	 * @var array
	 */
	private $_directories = array();
	
	/**
	 * Lista de aruqivos que serão incluídos no backup. Cada item deve conter
	 * o caminho completo da pasta
	 * 
	 * @var array
	 */
	private $_files = array();
	
	/**
	 * Flag que indica se o backup deverá incluir o dump do banco de dados. 
	 * Atenção: o dump não altera a estrutura do banco de dados, apenas limapa o 
	 * banco e insere as informações de backup. Caso a versão não seja compatível
	 * o banco não poderá ser restaurado e consequentemente os arquivos também não 
	 * serão restaurados, pois a operação do banco causará um erro e abortará a 
	 * restauração.
	 *
	 * @var bool
	 */
	private $_addDatabaseDump = true;
	
	/**
	 * Flag que indica se o backup deverá incluir os arquivos da pasta destinada a 
	 * arquivos particulares de plugs, usuários, etc...
	 *
	 * @var bool
	 */
	private $_addFiles = true;
	
	/**
	 * Inicializa um objeto de backup para gerar o arquivo de backup.
	 */
	public function __construct() {
		$this->_pathTemp = sys_get_temp_dir() . '/bkp/';
		ini_set( 'memory_limit', '128M' );
		if( file_exists( $this->_pathTemp . self::NOME_DUMP ) )
			unlink( $this->_pathTemp . self::NOME_DUMP );
		
		if( !is_dir( $this->_pathTemp ) )
			mkdir( $this->_pathTemp );
	}
	
	/**
	 * Gera o arquivo de backup. 
	 *
	 * @return bool True caso o arquivo tenha sido gerado com sucesso.
	 */
	public function create() {
		if( $this->_saveToDisk )
			$withFiles = '-files';

		if($this->_addDatabaseDump)
			$withDb = '-db';

		$this->_backupName  = 'bkp-' . date('Y-m-d-H-i-s') . $withFiles . $withDb . 'zip';
		$backupFile = new ZipFile( $this->_pathTemp . $this->_backupName );
		
		if($this->incluir_files) {
			foreach ( $this->_directories as $path) {
				$backupFile->addDirectory($path);
			}
			foreach ( $this->_files as $path) {
				$backupFile->addDirectory($path);
			}
		}
		
		if($this->incluir_bd) {
			$this->databaseDump();
			$backupFile->addFile($this->pasta_tmp . $this->_databaseDumpName, $this->_databaseDumpName);
		}
		$backupFile->close();
		
		if( !$this->_saveToDisk ) {
			copy( $this->_pathToSave . $this->_backupName, $this->_pathTemp . $this->_backupName );
			unlink( $this->_pathTemp . $this->_backupName );
			if( file_exists( $this->_pathTemp . $this->_databaseDumpName ) ) {
				unlink( $this->_pathTemp . $this->_databaseDumpName );
			}
		}
		return true;
	}
	
	public static function restore( $file ) {
	}
	
	public function addDirectory( $path ) {
		if ( is_dir( $path ) ) {
			$this->_directories[] = $path;
		} else {
			throw new FwException( 'O diretório informado em "' . $path . '" não é válido.' );
		}
	}
	
	public function addFile( $path ) {
		if ( is_file( $path ) ) {
			$this->_files[] = $path;
		} else {
			throw new FwException( 'O arquivo informado em "' . $path . '" não é válido.' );
		}
	}
	
	/**
	 * Gera um arquivo SQL na pasta temporária com os dados do banco de dados.
	 *
	 * @return bool True caso o arquivo tenha sido salvo com sucesso.
	 */
	private function databaseDump() {
		$lista_tabelas = mysql_list_tables(BD_NAME);
		$conteudo_banco .= "SET FOREIGN_KEY_CHECKS=0;\n";
		while($tabela = mysql_fetch_row($lista_tabelas))
			$conteudo_banco .= "DELETE FROM ".$tabela[0].";\n";//não coloca truncate! essa açlão não sofre rollback
		$conteudo_banco .= shell_exec("mysqldump -t --user=".BD_USER." --password=".BD_PASS." --host=".BD_HOST." --disable-keys=false --add-locks=false --extended-insert=false ".BD_NAME." 2>&1");//deixe os inserts individuais para facilitar o debug
		$conteudo_banco .= "SET FOREIGN_KEY_CHECKS=1;\n";
		return (file_put_contents($this->pasta_tmp.self::NOME_DUMP, $conteudo_banco));
	}
}

class Backup
{
	/**
	 * Restaura o sistema por força bruta, ou seja, apaga os arquivos e limpa o banco de dados, substituindo-os 
	 * pelo conteúdo do arquivo de backup.
	 * Em caso de falha no sistema de arquivos, ele não oferece maneira para recuperar os arquivos apagados.
	 * O método não faz controle de transição no banco de dados, deverá ser implementado no controle.
	 *
	 * @param string $path_file Caminho até o arquivo que será utilizado para a resturação.
	 * @param bool $forcar_versao Flag que indica se a restauração deverá ser feita mesmo com incompatibilidade de versões.
	 * @return bool True caso a restauração não tenha disparado erros (Atenção, caso arquivo do banco e/ou a pasta arquivos não sejam encontrados a restauração não será feita e o método poderá retornar true). 
	 */
	public static function restaurar($path_file, $forcar_versao = false)
	{
		$zip 			= new ZipArchive;
		if(!$zip->open($path_file))
			throw new Excecao("Não foi possível abrir o arquivo de backup para restauração.", ERRO_SISTEMA, debug_backtrace());
		else
		{
			if(!$forcar_versao && $zip->getArchiveComment() != SIS_VERSAO)
				return $zip->getArchiveComment();

			$sql = $zip->getFromName(self::NOME_DUMP);
			if($sql)
			{
				$arquivo_tmp_sql = tempnam(sys_get_temp_dir(), "sql_dump");
				file_put_contents($arquivo_tmp_sql, $sql);
				
				$erro_retornado = shell_exec("mysql --user='".BD_USER."' --password='".BD_PASS."' --host='".BD_HOST."' --database='".BD_NAME."' < $arquivo_tmp_sql 2>&1");//deixe os inserts individuais para facilitar o debug
				if($erro_retornado)
					throw new Excecao("Erro ao executar SQL de restauração ($erro_retornado).", ERRO_SISTEMA,debug_backtrace());
				unset($arquivo_tmp_sql);
			}
			if($zip->getNameIndex(0) == "arquivos/")
			{
				$destino = realpath(PATH_ARQUIVOS."../");
				self::limparArquivos(PATH_ARQUIVOS);
				if($zip->extractTo($destino))
					return unlink($destino."/".self::NOME_DUMP);
				else
					return false;
			}else
				return true;
		}
	}
	
	/**
	 * Apaga recursivamente o diretório informado no parâmetro. 
	 *
	 * @param string $diretorio Diretório que deve ser apagado recursivamente.
	 * @return bool True caso o diretório tenha sido apagado com sucesso
	 */
	private static function limparArquivos($diretorio)
	{
//		echo "\n\nLimpar $diretorio";
		$diretorio = realpath($diretorio);
		if (is_dir($diretorio) && !is_link($diretorio))
		{
//			echo " (Diretório $diretorio)";
			$dir = opendir($diretorio);

			while(($file = readdir($dir)) !== false)
			{
				if($file != "." && $file != "..")
					if(!self::limparArquivos($diretorio."/".$file))
						throw new Excecao("Não foi possível apagar um arquivo ou diretório: $file", ERRO_SISTEMA, debug_backtrace());
			}
//	        echo "\nEnfim, apagar $diretorio</li></ul>";
			return rmdir($diretorio);
		}else
		{
//			echo "\napagando arquivo $diretorio";
			return unlink($diretorio);
		}
	}
	
	/**
	 * método mágico para leitura dos atributos privados.
	 * Verifica se o atributo solicitado pode ser visualizados externamente.
	 *
	 * @param string $atributo Nome do atributo.
	 * @return mixed Valor do atributo no seu tipo original.
	 */
	public function __get($atributo)
	{
		switch ($atributo)
		{
			case "nome_zip_backup":
				return $this->nome_zip_backup;
			break;
			default:
				throw new Excecao("Atributo $atributo é privado na classe Backup", ERRO_SISTEMA, debug_backtrace());
			break;
		}
	}

}