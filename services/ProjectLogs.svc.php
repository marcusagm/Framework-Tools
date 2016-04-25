<?php
/**
 * Description of ProjectModels
 *
 * @author marcusmaia
 */
class ProjectLogs {

	private $projectId = null;

	private $path = null;

	public function __construct( $id ) {
		$ProjectConfig = new ProjectConfigs( $id );

		$this->projectId = $ProjectConfig->getId();
		$this->path = $ProjectConfig->getPath();
	}

	public function getLogs() {
		try {
			$path = $this->path . 'logs' . DS;
			$files = glob( $path . '*.txt');

			$return = array();
			foreach ( $files as $value ) {
				$file = basename( $value );
				$fileName = substr( $file, 0, -4 );
				$parser = explode( '_', $file );

				$year = substr( $parser[0], 0, 4);
				$month = substr( $parser[0], 4, 2);
				$day = substr( $parser[0], 6, 2);
				$hour = substr( $parser[1], 0, 2);
				$minute = substr( $parser[1], 2, 2);
				$seconds = substr( $parser[1], 4, 2);
				$microseconds = substr( $parser[2], 0, 4);

				$log = array();
				$log['date'] = $year . '-' . $month . '-' . $day;
				$log['time'] = $hour . ':' . $minute . ':' . $seconds . ' ' . $microseconds;
				$log['type'] = 'Unknown';
				$log['file'] = $fileName;
				$log['path'] = $value;

				$return[] = $log;
			}

			return $return;
		} catch ( FwException $e ) {
			echo $e->getMessage();
		}
	}

	public function readLog( $log ) {
		try {
			return file_get_contents( $path = $this->path . 'logs' . DS . $log . '.txt' );
		} catch ( FwException $e ) {
			echo $e->getMessage();
		}
	}

	public function deleteLog( $log ) {
		try {
			return unlink( $path = $this->path . 'logs' . DS . $log . '.txt' );
		} catch ( FwException $e ) {
			echo $e->getMessage();
		}
	}
}