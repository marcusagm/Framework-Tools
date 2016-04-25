<?php
class Project {
	private $id;
	private $name;
	private $path;

	public function __construct( $id = null ) {
		if( $id !== null && $id !== '' ) {
			$this->loadProjectFile( $id );
		} else {
			$this->id = md5( microtime() );
		}
	}

	public function getId() {
		return $this->id;
	}

	public function setName( $name ) {
		$this->name = $name;
		return $this;
	}

	public function getName() {
		return $this->name;
	}

	public function setPath( $path ) {
		if( substr( $path, -1 ) != '/' ) {
			$path .= '/';
		}

		if( !is_dir( $path ) ) {
			if( !mkdir ( $path, 775 ) ) {
				throw new FwException( 'Folder does not exist and cannot be created.' );
			}
		}
		$this->path = $path;
		return $this;
	}

	public function getPath() {
		return $this->path;
	}

	public function save() {
		$file = PROJECT_FILES_PATH . $this->id . '/project.json';

		$json = array(
			'id' => $this->id,
			'name' => $this->name,
			'path' => $this->path
		);

		if( !file_exists( PROJECT_FILES_PATH . $this->id ) ) {
			if( !mkdir( PROJECT_FILES_PATH . $this->id, 0775, true ) ) {
				throw new FwException( 'The project folder does not exist and cannot be created.' );
			}
			if( !mkdir( PROJECT_FILES_PATH . $this->id . '/models', 0775, true ) ) {
				throw new FwException( 'The project models folder does not exist and cannot be created.' );
			}
			if( !mkdir( PROJECT_FILES_PATH . $this->id . '/modules', 0775, true ) ) {
				throw new FwException( 'The project models folder does not exist and cannot be created.' );
			}
		}
		file_put_contents( $file, json_encode($json));
		return true;
	}

	public function delete() {
		if( $this->id !== null & $this->id != '' ) {
			$dirPath = PROJECT_FILES_PATH . $this->id;
			$this->removeFolder($dirPath);
		}
		return true;
	}

	public function generate() {
		$this->createProjectFolders();
		$this->copyProjectFiles();
		return true;
	}


	public static function getListProject() {
		$projects = array();
		$folders = glob( PROJECT_FILES_PATH . '*', GLOB_ONLYDIR );
		foreach ($folders as $value) {
			$projects[] = new Project( basename( $value ) );
		}
		return $projects;
	}

	private function createProjectFolders() {
		$struct = array(
			'config',
			'layouts',
			'logs',
			'models',
			'models/repositories',
			'modules',
			'modules/index',
			'modules/index/views',
			'resources',
			'services'
		);
		foreach ($struct as $path) {
			$dir = $this->path . $path;
			if( !file_exists( $dir ) ) {
				if( !mkdir( $dir, 0775, true) ) {
					throw new FwException( 'The folder "' . $path . '" cannot be created.' );
				}
			}
		}
		return true;
	}

	private function copyProjectFiles() {
		$struct = array(
			'public' => 'public',
			'controllers/index.ctrl.php' => 'modules/index/index.ctrl.php',
			'views/index.frm.php' => 'modules/index/views/index.frm.php'
		);
		foreach ($struct as $path => $destination ) {
			if( !file_exists(SYSROOT . 'resources/structure/' . $path) ) {
				throw new FwException( 'Resource not found: ' . SYSROOT . 'resources/structure/' . $path );
			}

			if( is_file( SYSROOT . 'resources/structure/' . $path ) ) {
				copy( SYSROOT . 'resources/structure/' . $path, $this->path . $destination );
			} else {
				if( !file_exists( $this->path . $path ) ) {
					if( !mkdir( $this->path . $path, 0775, true) ) {
						throw new FwException( 'The folder "' . $path . '" cannot be created.' );
					}
				}
				$this->copyFolder( SYSROOT . 'resources/structure/' . $path, $this->path . $path );
			}
		}
		return true;
	}

	private function loadProjectFile( $id ) {
		$file = PROJECT_FILES_PATH . $id . '/project.json';
		$contents = file_get_contents($file);
		if( $contents === false ) {
			throw new FwException( 'Cannot load project data.' );
		}
		$json = json_decode( $contents );

		$this->id = $json->id;
		$this->name = $json->name;
		$this->path = $json->path;
		return true;
	}

	private function removeFolder( $dirPath ) {
		if( file_exists( $dirPath ) ) {
			foreach(
				new RecursiveIteratorIterator(
					new RecursiveDirectoryIterator( $dirPath, FilesystemIterator::SKIP_DOTS ),
					RecursiveIteratorIterator::CHILD_FIRST
				) as $path
			) {
				$path->isFile() ? unlink($path->getPathname()) : rmdir($path->getPathname());
			}
			rmdir($dirPath);
		}
		return true;
	}

	private function copyFolder( $source, $destination ) {
		foreach (
			$iterator = new RecursiveIteratorIterator(
				new RecursiveDirectoryIterator($source, RecursiveDirectoryIterator::SKIP_DOTS),
				RecursiveIteratorIterator::SELF_FIRST
			) as $item
		) {
			if ($item->isDir()) {
				mkdir( $destination . DS . $iterator->getSubPathName(), 0775, true );
			} else {
				copy( $item, $destination . DS . $iterator->getSubPathName() );
			}
		}
		return true;
	}
}