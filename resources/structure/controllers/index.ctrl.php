<?php

class IndexController extends Controller {
	public function index() {
		$this->view->layout->title	= 'Project';
		$this->view->layout->layoutName = 'default';
	}
}