<?php

class ApiController extends Controller {
	function index( $id ) {
		$this->view->layout->title	= 'Modules - Framework Tools';
		$this->view->layout->layoutName = 'default';
		$this->view->record = new Project( $id );
	}
}