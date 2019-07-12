<?php

class LogsController extends Controller {
    public function index( $id ) {
        $this->view->layout->title    = 'Modules - Framework Tools';
        $this->view->layout->layoutName = 'default';
        $Logs = new ProjectLogs( $id );
        $this->view->record = new Project( $id );
        $this->view->logs = $Logs->getLogs();

        $this->view->message = Session::getVar('flash-message');
        Session::deleteVar('flash-message');
    }

    public function view( $projectId, $log ) {
        $this->view->isAjax = $this->isAjaxRequest();

        if( $this->view->isAjax ) {
            $this->view->autoLayout = false;
        } else {
            $this->view->layout->title    = 'Models - Framework Tools';
            $this->view->layout->layoutName = 'default';
        }

        $Logs = new ProjectLogs( $projectId );
        $this->view->log = $log;
        $this->view->logContent = $Logs->readLog( $log );
    }

    public function delete( $projectId, $log ) {
        try {
            $Logs = new ProjectLogs( $projectId );
            $Logs->deleteLog( $log );

            Session::setVar( 'flash-message', 'The log was deleted successfully' );
            $this->redirect( 'logs', 'index', array( 'id' => $projectId ) );
        } catch ( FwException $e ) {
            Session::setVar( 'flash-message', $e->getMessage() );
            $this->redirect( 'logs', 'index', array( 'id' => $projectId ) );
        }
    }

    public function deleteSelected() {
        try {
            $projectId = $this->getHttpData( 'project_id' );
            $logs = $this->getHttpData( 'logs' );

            $Logs = new ProjectLogs( $projectId );

            foreach ( $logs as $log ) {
                $Logs->deleteLog( $log );
            }

            Session::setVar( 'flash-message', 'The logs was deleted successfully' );
            $this->redirect( 'logs', 'index', array( 'id' => $projectId ) );
        } catch ( FwException $e ) {
            Session::setVar( 'flash-message', $e->getMessage() );
            $this->redirect( 'logs', 'index', array( 'id' => $projectId ) );
        }
    }
}