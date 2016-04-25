<?php

class ModulesController extends Controller {
	public function index( $id ) {
		$this->view->layout->title	= 'Modules - Framework Tools';
		$this->view->layout->layoutName = 'default';
		$this->view->record = new Project( $id );
		$this->view->projectModules = new ProjectModules( $id );
		$this->view->projectId = $id;

		$this->view->message = Session::getVar('flash-message');
		Session::deleteVar('flash-message');
	}

	public function generate( $id, $model ) {
		$Modules = new ProjectModules( $id );

		$this->view->isAjax = $this->isAjaxRequest();

		if( $this->view->isAjax ) {
			$this->view->autoLayout = false;
		} else {
			$this->view->layout->title	= 'Modules - Framework Tools';
			$this->view->layout->layoutName = 'default';
		}

		$this->view->record = new Project( $id );
		$this->view->projectId = $id;
		$this->view->modelName = $model;
		$this->view->model = $Modules->getModel( $model );
	}

	public function generateLayout( $id ) {
		try {
			$Layout = new ProjectLayouts( $id, 'bootstrap' );
			$Layout->makeLayout();

			Session::setVar( 'flash-message', 'The layout was created successfully' );
			$this->redirect( 'modules', 'index', array( 'id' => $id ) );
		} catch ( FwException $e ) {
			Session::setVar( 'flash-message', $e->getMessage() );
			$this->redirect( 'modules', 'index', array( 'id' => $id ) );
		}
	}

	public function save() {
		try {
			$Modules = new ProjectModules( $this->getHttpData( 'project_id' ) );
			$modelInfo = $Modules->getModel( $this->getHttpData( 'model_name' ) );

			$inputLabel = $this->getHttpData( 'input_label' );
			$inputType = $this->getHttpData( 'input_type' );
			$inputRequired = $this->getHttpData( 'input_required' );
			$inputGrid = $this->getHttpData( 'input_grid' );
			$inputSort = $this->getHttpData( 'input_sort' );

			$fields = array();
			foreach( $modelInfo['fields'] as $field ) {
				$attributes = array();
				preg_match('/(?P<type>\w+)($|\((?P<length>(\d+|(.*)))\))/', $field['Type'], $attributes);
				$fields[ $field[ 'Field' ] ] = array(
					'name'		=> $field[ 'Field' ],
					'label'		=> $inputLabel[ $field[ 'Field' ] ],
					'type'		=> $inputType[ $field[ 'Field' ] ],
					'db_type'	=> isset( $attributes['type'] ) ? $attributes['type'] : $field['Type'],
					'maxlength' => isset( $attributes['length'] ) ? $attributes['length'] : false,
					'default'	=> $field['Default'],
					'required'	=> isset( $inputRequired[ $field[ 'Field' ] ] ) ? true : false,
					'grid'		=> isset( $inputGrid[ $field[ 'Field' ] ] ) ? true : false,
					'sort'		=> $inputSort == $field[ 'Field' ] ? true : false
				);
			}

			$Modules->makeModule(
				$this->getHttpData( 'model_name' ),
				$fields
			);

			Session::setVar( 'flash-message', 'The module was created successfully' );
			$this->redirect( 'modules', 'index', array( 'id' => $this->getHttpData( 'project_id' ) ) );
		} catch ( FwException $e ) {
			Session::setVar( 'flash-message', $e->getMessage() );
			$this->redirect( 'modules', 'index', array( 'id' => $this->getHttpData( 'project_id' ) ) );
		}
	}
}