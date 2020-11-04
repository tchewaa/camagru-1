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
        $this->user = new Users();
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
            $this->request->csrfCheck();
            $current_password = $this->request->get('password');
            $new_password = $this->request->get('new_password');
            $confirm_password = $this->request->get('confirm_password');
            if (password_verify($current_password, Users::currentUser()->password)) {
                $this->user->password = $new_password;
                $this->user->setConfirm($confirm_password);
                $this->user->validator();
                if ($this->user->validationPassed()) {
                    $new_password = password_hash($new_password, PASSWORD_DEFAULT);
                    $id = Users::currentUser()->id;
                    $this->user->update($id, ['password' => $new_password]);
                    Router::redirect('home');
                }
                $this->view->validationMessages = $this->user->getErrorMessages();
            } else {
                //TODO custom error message
                $this->view->validationMessages = ['password' => 'Invalid password'];
            }
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