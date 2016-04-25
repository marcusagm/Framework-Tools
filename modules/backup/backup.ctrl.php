<?php

class BackupController extends Controller {
	function index( $id ) {
		$this->view->layout->title	= 'Backup - Framework Tools';
		$this->view->layout->layoutName = 'default';
		$this->view->record = new Project( $id );
	}
}