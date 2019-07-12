<?php

class IndexController extends Controller {
    function index() {
        $this->view->layout->title    = 'Projects - Framework Tools';
        $this->view->layout->layoutName = 'default';
    }
}