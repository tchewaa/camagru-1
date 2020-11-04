<?php


namespace App\Controllers;


use App\Models\Users;
use Core\Controller;
use Core\Helpers;
use Core\Router;

class ProfileController extends Controller {
    public $user;

    public function __construct($controller, $action){
        parent::__construct($controller, $action);
        $this->load_model('Users');
        $this->view->setLayout('default');
    }

    public function indexAction() {
        //TODO create index page for profile
        $this->view->render('profile/updateUsername');
    }

    public function updateUsernameAction() {
        if ($this->request->isPost()) {
            $user = new Users();
            $this->request->csrfCheck();
            $user->assign($this->request->get());
            $user->validator();
            $username = $this->request->get('username');
            if ($user->validationPassed()) {
                $u = Users::$currentLoggedInUser;
                $user->update($u->id, ['username' => $username]);
                Router::redirect('home');
            }
            $this->view->validationMessages = $user->getErrorMessages();
        }
        $this->view->render('profile/updateUsername');
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