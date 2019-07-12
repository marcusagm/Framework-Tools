<?php

class ConfigController extends Controller {
    public function __construct($language = null) {
        parent::__construct($language);

        $this->view->layout->title    = 'Configuration - Framework Tools';
        $this->view->layout->layoutName = 'default';
        $this->view->record = null;
        $this->view->message = Session::getVar('flash-message');
        Session::deleteVar('flash-message');
    }

    public function index( $id ) {
        $this->view->record = new ProjectConfigs( $id );
        $this->view->name = 'index';
        $this->view->projectId = $id;
    }

    public function add( $id ) {
        $this->view->record = new ProjectConfigs( $id );
        $this->view->name = 'index';
        $this->view->projectId = $id;
    }

    public function edit( $id ) {
        $this->view->record = new ProjectConfigs( $id );
        $this->view->name = 'index';
        $this->view->projectId = $id;
    }

    public function save() {
        try {
            $Project = new ProjectConfigs( $this->getHttpData( 'project_id' ) );

            $Project->setVersion( $this->getHttpData( 'project_version' ) );
            $Project->setUseTranslations( 'false' );
            $Project->setLanguage( $this->getHttpData( 'project_language' ) );
            $Project->setCharset( $this->getHttpData( 'project_charset' ) );

            $Project->setBaseUrl( $this->getHttpData( 'project_url' ) );
            $Project->setModuleIndex( $this->getHttpData( 'project_module_index' ) );

            $Project->setEnvironment( $this->getHttpData( 'project_environment' ) );
            $Project->setDebug( $this->getHttpData( 'project_debug' ) );
            $Project->setReport( $this->getHttpData( 'project_report' ) );
            $Project->setReportEmailSubject( $this->getHttpData( 'project_report_subject' ) );
            $Project->setReportEmail( $this->getHttpData( 'project_report_mail' ) );

            $Project->setDatabaseType( $this->getHttpData( 'database_type' ) );
            $Project->setDatabaseHost( $this->getHttpData( 'database_host' ) );
            $Project->setDatabaseName( $this->getHttpData( 'database_name' ) );
            $Project->setDatabaseUsername( $this->getHttpData( 'database_user' ) );
            $Project->setDatabasePassword( $this->getHttpData( 'database_password' ) );
            $Project->setDatabasePrefix( $this->getHttpData( 'database_prefix' ) );
            $Project->save();
            $Project->generate();

            Session::setVar( 'flash-message', 'The project configuration file was created successfully' );
            $this->redirect( 'config', 'edit', array( 'id' => $Project->getId() ) );
        } catch ( FwException $e ) {
            Session::setVar( 'flash-message', $e->getMessage() );
            $this->redirect( 'config', 'add', array( 'id' => $Project->getId() ) );
        }
    }
}