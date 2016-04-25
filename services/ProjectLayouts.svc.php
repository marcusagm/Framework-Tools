<?php
/**
 * Description of ProjectModels
 *
 * @author marcusmaia
 */
class ProjectLayouts {
	private $projectId = null;

	private $path = null;

	private $modules = array();

	private $template = 'bootstrap';

	public function __construct( $id, $template ) {
		$ProjectConfig = new ProjectConfigs( $id );
		$ProjectModules = new ProjectModules( $id );

		$this->projectId = $ProjectConfig->getId();
		$this->path = $ProjectConfig->getPath();
		$this->modules = $ProjectModules->getRegistredModules();
	}

	public function makeLayout() {
		$modules = $this->modules;
		
		ob_start();
		include( dirname(__DIR__) .
				DIRECTORY_SEPARATOR . 'resources' .
				DIRECTORY_SEPARATOR . 'structure' .
				DIRECTORY_SEPARATOR . 'layouts' .
				DIRECTORY_SEPARATOR . $this->template .
				DIRECTORY_SEPARATOR . 'default.lay.php'
		);
		$layout = ob_get_contents();
		ob_end_clean();

		$path = $this->path . 'layouts/';

		if( !file_exists( $path ) ) {
			if( !mkdir( $path, 0775, true ) ) {
				throw new FwException( 'The module folder does not exist and cannot be created.' );
			}
		}

		file_put_contents( $path . 'default.lay.php' , $layout );
		chmod( $path . '/default.lay.php' , 0775 );
	}
}