<?php


class Home extends Controller {

    public function __construct($controller, $action){
        parent::__construct($controller, $action);
    }

    public function indexAction($name) {
        if (!Session::exists(CURRENT_USER_SESSION_NAME)) {
            $this->view->render('register/login');
        } else {
            $this->view->render('home/index');
        }
    }
}