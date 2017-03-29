<?php
/**
 * Description of ProjectModels
 *
 * @author marcusmaia
 */
class ProjectModels {
	const STATUS_NOT_GENERATED = 0;
	const STATUS_GENERATED = 1;
	const STATUS_MODIFIED = 2;

	private $projectId = null;

	private $path = null;

	private $databaseType = 'mysql';
	private $databaseName = null;
	private $databaseHost = '127.0.0.1';
	private $databaseUsername = 'root';
	private $databasePassword = '';
	private $databasePrefix = null;

	private $tables = array();
	private $tablesColumns = array();
	private $tablesForeingKeys = array();
	private $tablesReferencedForeingKeys = array();

    /**
     * Conexão com o banco de dados.
     *
     * @var PDO
     */
	private $_conn = false;

	public function __construct( $id )
    {
		$ProjectConfig = new ProjectConfigs( $id );

		$this->projectId = $ProjectConfig->getId();
		$this->path = $ProjectConfig->getPath();

		$this->databaseType = $ProjectConfig->getDatabaseType();
		$this->databaseName = $ProjectConfig->getDatabaseName();
		$this->databaseHost = $ProjectConfig->getDatabaseHost();
		$this->databaseUsername = $ProjectConfig->getDatabaseUsername();
		$this->databasePassword = $ProjectConfig->getDatabasePassword();
		$this->databasePrefix = $ProjectConfig->getDatabasePrefix();

		$this->connect();
		$this->readTables();
		$this->readColumns();
		$this->readForeingKeys();
		$this->readReferencedForeingKeys();
	}

	public function __destruct()
    {
		//mysql_close($this->_conn );
	}

	public function connect()
    {
        $options = array( PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8" );
        $this->_conn = new PDO(
            'mysql:host=' . $this->databaseHost .
            ';dbname=' . $this->databaseName,
            $this->databaseUsername,
            $this->databasePassword,
            $options
        );
	}

	public function getTables()
    {
		return $this->tables;
	}

	public function getTableName( $modelName, $removePrefix = false )
    {
		$return = $removePrefix === false ? $this->databasePrefix . '_' : '';
		$return .= $this->underscore( $modelName );
		return $return;
	}

	public function getTableData( $table )
    {
		if( !isset( $this->tablesColumns[$table] ) ) {
			throw new FwException( 'The table "' . $table . '" is not found.' );
		}

		return $this->tablesColumns[$table];
	}

	public function getModelNames()
    {
		$tables = $this->getTables();
		$models = array();
		foreach ( $tables as $table ) {
			$models[] = $this->camelize( $this->removePrefix( $table ) );
		}
		return $models;
	}

	public function getModelName( $table )
    {
		return $this->camelize( $this->removePrefix( $table ) );
	}

	public function getModelData( $table )
    {
		try {
			$model = $this->loadModelFile( $table, true );
			if( $model === false ) {
				throw new FwException( 'The model for table "' . $table . '" is not found.' );
			}
			return $model;
		} catch ( FwException $ex ) {
			echo $ex->getMessage();
		}
	}

	public function getModelStatus( $table )
    {
		$model = $this->loadModelFile( $table, true );
		if( $model === false ) {
			return self::STATUS_NOT_GENERATED;
		}
		$fields = $this->getFields( $table );

		if( serialize( $fields ) === serialize( $model['fields'] ) ) {
			return self::STATUS_GENERATED;
		}
		return self::STATUS_MODIFIED;
	}

	public function getFields($table)
    {
		return $this->tablesColumns[$table];
	}

	public function getForeingKeys($table)
    {
		if( !isset( $this->tablesForeingKeys[$table] ) ) {
			return false;
		}
		return $this->tablesForeingKeys[$table];
	}

	public function getReferencedForeingKeys($table)
    {
		if( !isset( $this->tablesReferencedForeingKeys[$table] ) ) {
			return false;
		}
		return $this->tablesReferencedForeingKeys[$table];
	}

	public function updateModelsData()
    {
		try {
			$path = $this->path . 'models' . DS . 'repositories' . DS;
			$files = glob( $path . '*.rep.php');

			// Percorrer lista de arquivos carregando as informações
			foreach ( $files as $file ) {
				// Instanciar as models do projeto e obter as informações
				require_once $file;
				$className = basename( $file, '.rep.php');
				$instance = new ReflectionClass( $className . 'Repository' );
				$defaultValues = $instance->getDefaultProperties();
				$schema = $defaultValues['_schema'];

				// Ler arquivo de model gerado
				$tableName = $this->databasePrefix . '_' . $this->underscore( $className );
				$modelData = $this->loadModelFile( $tableName, true );
				if( $modelData === false ) {
					throw new FwException( 'The JSON file for table "' . $tableName . '" is not found.' );
				}

				// Atualizar os dados dos arquivos
				if( serialize( $modelData['fields'] === serialize( $schema ) ) ) {
					$modelData['fields'] = $schema;

					$file = PROJECT_FILES_PATH . $this->projectId . DS . 'models' . DS . $tableName . '.json';
					if( file_put_contents( $file, json_encode( $modelData ) ) === false ) {
						throw new FwException( 'The model for ' . $tableName . ' cannot be saved.');
					}
					chmod($file, 0775);
				}
			}
		} catch ( FwException $e ) {
			echo $e->getMessage();
		}
	}

	public function makeRepositories( $tableNames = false )
    {
		try {
			$ProjectConfig = new ProjectConfigs( $this->projectId );
			$tables = $this->getTables();
			foreach ( $tables as $table ) {
				$generateTable = false;
				if( $tableNames === false || ( is_array( $tableNames ) && in_array( $table, $tableNames ) ) ) {
					$generateTable = true;
				}

				if( $generateTable === true ) {
					$tableName = $this->camelize( $this->removePrefix( $table ) );
					$status = $this->getModelStatus( $table );
					$fields = $this->getFields( $table );
					$foreingKeys = $this->getForeingKeys( $table );
					$referencedForeingKeys = $this->getReferencedForeingKeys( $table );

					// Obtem a data de criação do módulo
					$date = date('Y-m-d H:i:s');

					// Obtem a versão em que foi criado o módulo
					$version = $ProjectConfig->getVersion();

					ob_start();
					include( dirname(__DIR__) .
						DS . 'resources' .
						DS . 'structure' .
						DS . 'models' .
						DS . 'repository.php'
					);
					$model = ob_get_contents();
					ob_end_clean();
					if( !file_put_contents( $this->path . 'models' . DS . 'repositories'. DS . $tableName . '.rep.php' , $model ) ) {
						throw new FwException( 'The repository for ' . $tableName . ' cannot be created.');
					}
					chmod($this->path . 'models'. DS . 'repositories'. DS . $tableName . '.rep.php' , 0775);

					$file = PROJECT_FILES_PATH . $this->projectId . DS . 'models' . DS . $table . '.json';

					$json = array(
						'fields' => $fields,
						'foreingKeys' => $foreingKeys,
						'referencedForeingKeys' => $referencedForeingKeys,
						'status' => $status
					);
					if( file_put_contents( $file, json_encode( $json ) ) === false ) {
						throw new FwException( 'The repository for ' . $tableName . ' cannot be saved.');
					}
					chmod($file, 0775);
				}
			}
		} catch (FwException $e) {
			echo $e->getMessage();
		}
	}

	public function makeModels( $tableNames = false )
    {
		try {
			$ProjectConfig = new ProjectConfigs( $this->projectId );

			$tables = $this->getTables();
			foreach ( $tables as $table ) {
				$generateTable = false;
				if( $tableNames === false || ( is_array( $tableNames ) && in_array( $table, $tableNames ) ) ) {
					$generateTable = true;
				}

				if( $generateTable === true ) {
					$tableName = $this->camelize( $this->removePrefix( $table ) );

					// Obtem a data de criação do módulo
					$date = date('Y-m-d H:i:s');

					// Obtem a versão em que foi criado o módulo
					$version = $ProjectConfig->getVersion();

					ob_start();
					include( dirname(__DIR__) .
						DS . 'resources' .
						DS . 'structure' .
						DS . 'models' .
						DS . 'models.php'
					);
					$model = ob_get_contents();
					ob_end_clean();
					if( file_put_contents( $this->path . 'models' . DS . $tableName . '.mdl.php' , $model ) === false ) {
						throw new FwException( 'The model for ' . $tableName . ' cannot be created.');
					}
					chmod($this->path . 'models' . DS . $tableName . '.mdl.php' , 0775);
				}
			}
		} catch (FwException $e) {
			echo $e->getMessage();
		}
	}

	public function hasGeneratedModels()
    {
		$path = $this->path . 'models' . DS;
		$files = glob( $path . '*.mdl.php');
		return count( $files ) > 0 ? true : false;
	}

	public function hasGeneratedModel( $table )
    {
		$file = PROJECT_FILES_PATH . $this->projectId . DS . 'models' . DS . $table . '.json';
		if( !file_exists( $file ) ) {
			return false;
		}
		return true;
	}

	private function readTables()
    {
        try {
            $query = 'SHOW TABLES LIKE "' . $this->databasePrefix . '%"';
            $sql = $this->_conn->query( $query );
            $this->tables = $sql->fetchAll(PDO::FETCH_COLUMN);
            $error = $this->_conn->errorInfo();
			if( $error[0] !== '00000' ) {
				throw new FwException('Ocorreu um erro ao executar a query: ' .
									   $query . ' - Erro: ' . $error[2] );
			}
        } catch (FwException $e) {
        }
	}

	private function readColumns()
    {
        try {
            $tables = $this->getTables();
            foreach ( $tables as $table ) {
                $sql = $this->_conn->query( 'DESCRIBE ' . $table );
                $this->tablesColumns[$table] = $sql->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (FwException $e) {
        }
	}

	private function readForeingKeys()
    {
        try {
            $tables = $this->getTables();
            foreach ( $tables as $table ) {
                $this->tablesForeingKeys[$table] = array();

                $sql = "SELECT
                        COLUMN_NAME,
                        REFERENCED_TABLE_SCHEMA,
                        REFERENCED_TABLE_NAME,
                        REFERENCED_COLUMN_NAME
                    FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
                    WHERE TABLE_SCHEMA = '" . $this->databaseName . "'
                        AND REFERENCED_TABLE_NAME IS NOT NULL
                        AND TABLE_NAME = '" . $table . "'";
                $res = $this->_conn->query( $sql );
                $this->tablesForeingKeys[$table] = $res->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (FwException $e) {
        }
	}

	private function readReferencedForeingKeys()
    {
        try {
            $tables = $this->getTables();
            foreach ( $tables as $table ) {
                $this->tablesReferencedForeingKeys[$table] = array();

                $sql = "SELECT
                            TABLE_NAME,
                            COLUMN_NAME,
                            REFERENCED_TABLE_SCHEMA,
                            REFERENCED_TABLE_NAME,
                            REFERENCED_COLUMN_NAME
                        FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
                        WHERE TABLE_SCHEMA = '" . $this->databaseName . "'
                            AND REFERENCED_TABLE_NAME = '" . $table . "'
                            AND TABLE_NAME IS NOT NULL";
                $res = $this->_conn->query(  $sql );
                $this->tablesReferencedForeingKeys[$table] = $res->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (FwException $e) {
        }
	}

	private function loadModelFile( $table, $asArray = false )
    {
		$file = PROJECT_FILES_PATH . $this->projectId . DS . 'models' . DS . $table . '.json';
		if( !file_exists( $file ) ) {
			return false;
		}

		$contents = file_get_contents($file);
		if( $contents === false ) {
			return false;
		}
		return json_decode( $contents, $asArray );
	}

	private function camelize( $text )
    {
		return str_replace( ' ', '', ucwords( str_replace( array( '_', '-' ), ' ', $text ) ) );
	}

	private function underscore( $text )
    {
		return strtolower( preg_replace( '/(?<=\\w)([A-Z])/', '_\\1', $text ) );
	}

	private function removePrefix( $text )
    {
		$prefix = array(
			$this->databasePrefix . '_',
			'_id',
			'fk_'
		);
		return str_replace( $prefix, '', $text );
	}
}