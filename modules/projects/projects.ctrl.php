<?php

class ProjectsController extends Controller {
    public function __construct($language = null) {
        parent::__construct($language);

        $this->view->layout->title    = 'Projects - Framework Tools';
        $this->view->layout->layoutName = 'default';
        $this->view->record = null;
        $this->view->message = Session::getVar('flash-message');
        Session::deleteVar('flash-message');
    }

    public function index() {
        $this->view->record = null;
        $this->view->name = 'index';
    }

    public function add() {
        $this->view->record = null;
        $this->view->name = 'index';
    }

    public function edit( $id ) {
        $this->view->record = new Project( $id );
        $this->view->name = 'index';
    }

    public function save() {
        try {
            $Project = new Project( $this->getHttpData( 'project_id' ) );
            $Project->setName( $this->getHttpData( 'project_name' ) );
            $Project->setPath( $this->getHttpData( 'project_path' ) );
            $Project->save();
            $Project->generate();

            Session::setVar( 'flash-message', 'The project was created successfully' );
            $this->redirect( 'projects', 'edit', array( 'id' => $Project->getId() ) );
        } catch ( FwException $e ) {
            Session::setVar( 'flash-message', $e->getMessage() );
            $this->redirect( 'projects', 'add' );
        }
    }

    public function delete( $id ) {
        $Project = new Project( $id );
        $Project->delete();
        Session::setVar('flash-message', 'The project was successfully deleted');
        $this->redirect( 'projects', 'add' );
    }
}