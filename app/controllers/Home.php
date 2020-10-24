<?php


class Home extends Controller {

    public function __construct($controller, $action){
        parent::__construct($controller, $action);
    }

    public function indexAction($name) {
        $db = DB::getInstance();
        $contactsQ = $db->delete('contacts', 2);
        $this->view->render('home/index');
    }
}