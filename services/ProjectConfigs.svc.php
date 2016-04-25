<?php
/**
 * Description of ProjectModels
 *
 * @author marcusmaia
 */

class ProjectConfigs {
	private $id;

	private $name;
	private $version;
	private $language = 'pt-br';
	private $useTranslations = 'false';
	private $charset = 'utf8';

	private $path = null;
	private $baseUrl = null;
	private $moduleIndex = 'index';

	private $environment = 'development';
	private $debug = '1';
	private $report = '0';
	private $reportEmail = null;
	private $reportEmailSubject = 'Report Error';

	private $databaseType = 'mysql';
	private $databaseName = null;
	private $databaseHost = '127.0.0.1';
	private $databaseUsername = 'root';
	private $databasePassword = '';
	private $databasePrefix = null;

	public function getId() {
		return $this->id;
	}

	public function setId($id) {
		$this->id = $id;
		return $this;
	}

	public function getName() {
		return $this->name;
	}

	public function setName($name) {
		$this->name = $name;
		return $this;
	}

	public function getVersion() {
		return $this->version;
	}

	public function setVersion($version) {
		$this->version = $version;
		return $this;
	}

	public function getLanguage() {
		return $this->language;
	}

	public function setLanguage($language) {
		$this->language = $language;
		return $this;
	}

	public function getUseTranslations() {
		return $this->useTranslations;
	}

	public function setUseTranslations($useTranslations) {
		$this->useTranslations = (string) $useTranslations;
		return $this;
	}

	public function getCharset() {
		return $this->charset;
	}

	public function setCharset($charset) {
		$this->charset = $charset;
		return $this;
	}

	public function getPath() {
		return $this->path;
	}

	public function setPath($path) {
		$this->path = $path;
		return $this;
	}

	public function getBaseUrl() {
		return $this->baseUrl;
	}

	public function setBaseUrl($baseUrl) {
		$this->baseUrl = $baseUrl;
		return $this;
	}

	public function getModuleIndex() {
		return $this->moduleIndex;
	}

	public function setModuleIndex($moduleIndex) {
		$this->moduleIndex = $moduleIndex;
		return $this;
	}

	public function getEnvironment() {
		return $this->environment;
	}

	public function setEnvironment($environment) {
		$this->environment = $environment;
		return $this;
	}

	public function getDebug() {
		return $this->debug;
	}

	public function setDebug($debug) {
		if( $debug >= 0 && $debug <= 2 )
			$this->debug = $debug;
		return $this;
	}

	public function getReport() {
		return $this->report;
	}

	public function setReport($report) {
		if( $debug >= 0 && $debug <= 2 )
			$this->report = $report;
		return $this;
	}

	public function getReportEmail() {
		return $this->reportEmail;
	}

	public function setReportEmail($reportEmail) {
		$this->reportEmail = $reportEmail;
		return $this;
	}

	public function getReportEmailSubject() {
		return $this->reportEmailSubject;
	}

	public function setReportEmailSubject($reportEmailSubject) {
		$this->reportEmailSubject = $reportEmailSubject;
		return $this;
	}

	public function getDatabaseHost() {
		return $this->databaseHost;
	}

	public function setDatabaseHost($databaseHost) {
		$this->databaseHost = $databaseHost;
		return $this;
	}

	public function getDatabaseUsername() {
		return $this->databaseUsername;
	}

	public function setDatabaseUsername($databaseUsername) {
		$this->databaseUsername = $databaseUsername;
		return $this;
	}

	public function getDatabasePassword() {
		return $this->databasePassword;
	}

	public function setDatabasePassword($databasePassword) {
		$this->databasePassword = $databasePassword;
		return $this;
	}

	public function getDatabaseType() {
		return $this->databaseType;
	}

	public function setDatabaseType($databaseType) {
		$this->databaseType = $databaseType;
		return $this;
	}

	public function getDatabaseName() {
		return $this->databaseName;
	}

	public function setDatabaseName($databaseDatabase) {
		$this->databaseName = $databaseDatabase;
		return $this;
	}

	public function getDatabasePrefix() {
		return $this->databasePrefix;
	}

	public function setDatabasePrefix($databasePrefix) {
		$this->databasePrefix = $databasePrefix;
		return $this;
	}

	public function __construct( $id = null ) {
		if( $id !== null && $id !== '' ) {
			$Project = new Project( $id );
			$this->id = $Project->getId();
			$this->name = $Project->getName();
			$this->path = $Project->getPath();
			$file = PROJECT_FILES_PATH . $id . DS .'config.json';
			if( file_exists( $file ) ) {
				$this->loadProjectFile($id);
			}
		} else {
			throw new FwException( 'The id project is null. Cannot load configuration data.' );
		}
	}

	public function save() {
		$file = PROJECT_FILES_PATH . $this->id . DS . 'config.json';
		$json = array(
			'version' => $this->version,
			'language' => $this->language,
			'useTranslations' => $this->useTranslations,
			'charset' => $this->charset,

			'baseUrl' => $this->baseUrl,

			'environment' => $this->environment,
			'debug' => $this->debug,
			'report' => $this->report,
			'reportEmail' => $this->reportEmail,
			'reportEmailSubject' => $this->reportEmailSubject,

			'databaseName' => $this->databaseName,
			'databaseHost' => $this->databaseHost,
			'databaseUsername' => $this->databaseUsername,
			'databasePassword' => $this->databasePassword,
			'databasePrefix' => $this->databasePrefix
		);

		if( !file_exists( PROJECT_FILES_PATH . $this->id ) ) {
			if( !mkdir( PROJECT_FILES_PATH . $this->id, 0777 ) ) {
				throw new FwException( 'The project folder does not exist and cannot be created.' );
			}
		}
		if( file_put_contents( $file, json_encode( $json ) ) === false ) {
			throw new FwException( 'The project cannot be saved.');
		}
		chmod( $file , 0775 );
		return true;
	}

	public function generate() {
		ob_start();
		include( dirname(__DIR__) .
			DS . 'resources' .
			DS . 'structure' .
			DS . 'configs' .
			DS . 'core.php'
		);
		$core = ob_get_contents();
		ob_end_clean();
		if( file_put_contents( $this->path . 'config' . DS . 'core.php' , $core ) === false ) {
			throw new FwException( 'The core configuration file cannot be saved.');
		}
		chmod( $this->path . 'config' . DS . 'core.php' , 0775 );

		ob_start();
		include( dirname(__DIR__) .
			DS . 'resources' .
			DS . 'structure' .
			DS . 'configs' .
			DS . 'database.php'
		);
		$database = ob_get_contents();
		ob_end_clean();
		if( file_put_contents( $this->path . 'config' . DS . 'database.php' , $database ) === false ) {
			throw new FwException( 'The database configuration file cannot be saved.');
		}
		chmod( $this->path . 'config' . DS . 'database.php' , 0775 );

		ob_start();
		include( dirname(__DIR__) .
			DS . 'resources' .
			DS . 'structure' .
			DS . 'configs' .
			DS . 'errors.php'
		);
		$errors = ob_get_contents();
		ob_end_clean();
		if( file_put_contents( $this->path . 'config' . DS . 'errors.php' , $errors ) === false ) {
			throw new FwException( 'The errors configuration file cannot be saved.');
		}
		chmod( $this->path . 'config' . DS . 'errors.php' , 0775 );

		ob_start();
		include( dirname(__DIR__) .
			DS . 'resources' .
			DS . 'structure' .
			DS . 'configs' .
			DS . 'routes.php'
		);
		$routes = ob_get_contents();
		ob_end_clean();
		if( file_put_contents( $this->path . 'config' . DS . 'routes.php' , utf8_decode( $routes ) ) === false ) {
			throw new FwException( 'The routes configuration file cannot be saved.');
		}
		chmod( $this->path . 'config' . DS . 'routes.php' , 0775 );
	}

	public function hasConfigFileGenerated() {
		return file_exists( PROJECT_FILES_PATH . $this->getId() . DS . 'config.json' );
	}

	private function loadProjectFile( $id ) {
		$file = PROJECT_FILES_PATH . $id . DS . 'config.json';
		$contents = file_get_contents($file);
		if( $contents === false ) {
			throw new FwException( 'Cannot load configuration data.' );
		}
		$json = json_decode( $contents );

		$this->version = $json->version;
		$this->language = $json->language;
		$this->useTranslations = $json->useTranslations;
		$this->charset = $json->charset;

		$this->baseUrl = $json->baseUrl;

		$this->environment = $json->environment;
		$this->debug = $json->debug;
		$this->report = $json->report;
		$this->reportEmail = $json->reportEmail;
		$this->reportEmailSubject = $json->reportEmailSubject;

		$this->databaseName = $json->databaseName;
		$this->databaseHost = $json->databaseHost;
		$this->databaseUsername = $json->databaseUsername;
		$this->databasePassword = $json->databasePassword;
		$this->databasePrefix = $json->databasePrefix;
		return true;
	}
}