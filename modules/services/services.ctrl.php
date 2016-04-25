<?php

class ServicesController extends Controller {
	function index( $id ) {
		$this->view->layout->title	= 'Services - Framework Tools';
		$this->view->layout->layoutName = 'default';
		$this->view->record = new Project( $id );
	}
}