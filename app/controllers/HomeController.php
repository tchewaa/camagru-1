<?php


class HomeController extends Controller {

    public function __construct($controller, $action){
        parent::__construct($controller, $action);
    }

    public function indexAction($name) {
        Session::addMessage('info', 'This is an info alert');
        Session::addMessage('success', 'This is an success alert');
        Session::addMessage('warning', 'This is an warning alert');
        Session::addMessage('danger', 'This is an danger alert');

        $this->view->render('home/index');
    }
}