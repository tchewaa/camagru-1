<?php


namespace App\Controllers;


use Core\Controller;

class ProfileController extends Controller {
    public $user;

    public function __construct($controller, $action){
        parent::__construct($controller, $action);
    }

    public function indexAction() {
        $this->view->render('profile/index');
    }

    public function updateDetailsAction() {
        if ($this->request->isPost()) {
            echo "Updating details";
        }
        $this->view->render('profile/updateDetails');
    }

    public function updatePasswordAction() {
        if ($this->request->isPost()) {
            echo "Updating Password";
        }
        $this->view->render('profile/updatePassword');
    }

    public function updateEmailAction() {
        if ($this->request->isPost()) {
            echo "Updating Email";
        }
        $this->view->render('profile/updateEmail');
    }
}