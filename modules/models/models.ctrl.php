<?php

class ModelsController extends Controller {
	public function index( $id ) {
		$this->view->layout->title	= 'Models - Framework Tools';
		$this->view->layout->layoutName = 'default';
		$this->view->record = new Project( $id );
		$this->view->projectModel = new ProjectModels( $id );
		$this->view->projectId = $id;

		$this->view->message = Session::getVar('flash-message');
		Session::deleteVar('flash-message');
	}

	public function view( $id, $table ) {
		$Models = new ProjectModels( $id );
		$this->view->isAjax = $this->isAjaxRequest();

		if( $this->view->isAjax ) {
			$this->view->autoLayout = false;
		} else {
			$this->view->layout->title	= 'Models - Framework Tools';
			$this->view->layout->layoutName = 'default';
		}

		$this->view->record = new Project( $id );
		$this->view->projectModel = new ProjectModels( $id );
		if( $Models->hasGeneratedModel( $table ) ) {
			$this->view->model = $Models->getModelData($table);
		}
		$this->view->table = $Models->getTableData($table);
		$this->view->tableName = $table;
		$this->view->modelName = $Models->getModelName($table);
	}

	public function save() {
		try {
			$Models = new ProjectModels( $this->getHttpData( 'project_id' ) );
			$tables = $this->getHttpData( 'tables' );

			if( is_array( $tables ) && count( $tables ) ) {
				$Models->makeRepositories( $tables );
			} else {
				$Models->makeRepositories();
			}

			if( $this->getHttpData( 'genarate_only_repositories' ) != '1' ) {
				if( is_array( $tables ) && count( $tables ) ) {
					$Models->makeModels( $tables );
				} else {
					$Models->makeModels();
				}
			}

			Session::setVar( 'flash-message', 'The models was created successfully' );
			$this->redirect( 'models', 'index', array( 'id' => $this->getHttpData( 'project_id' ) ) );
		} catch ( FwException $e ) {
			Session::setVar( 'flash-message', $e->getMessage() );
			$this->redirect( 'models', 'index', array( 'id' => $this->getHttpData( 'project_id' ) ) );
		}
	}

	public function uptadeModelData( $id ) {
		try {
			$Models = new ProjectModels( $id );
			$Models->updateModelsData();

			Session::setVar( 'flash-message', 'The models was updated successfully' );
			$this->redirect( 'models', 'index', array( 'id' => $id ) );
		} catch ( FwException $e ) {
			Session::setVar( 'flash-message', $e->getMessage() );
			$this->redirect( 'models', 'index', array( 'id' => $id ) );
		}
	}
}