<?php


namespace App\Controllers;


use App\Models\User;
use App\Models\Verification;
use Core\Controller;
use Core\Helper;
use Core\Router;

class ProfileController extends Controller {
    public $user;

    public function __construct($controller, $action){
        parent::__construct($controller, $action);
        $this->load_model('User');
        $this->view->setLayout('default');
    }

    public function indexAction() {
        $this->view->user = User::currentUser();
        $this->view->render('profile/index');
    }

    public function updateUsernameAction() {
        if ($this->request->isPost()) {
            $this->request->csrfCheck();
            $this->UserModel->assign($this->request->get());
            $this->UserModel->validator();
            $username = $this->request->get('username');
            if ($this->UserModel->validationPassed()) {
                $this->UserModel->update(User::currentUser()->id, ['username' => $username]);
                Router::redirect('profile/index');
            }
            $this->view->validationMessages = $this->UserModel->getErrorMessages();
        }
        $this->view->render('profile/updateUsername');
    }

    public function updatePasswordAction() {
        if ($this->request->isPost()) {
            $this->request->csrfCheck();
            $current_password = $this->request->get('password');
            $new_password = $this->request->get('new_password');
            $confirm_password = $this->request->get('confirm_password');
            if (password_verify($current_password, User::currentUser()->password)) {
                $this->UserModel->password = $new_password;
                $this->UserModel->setConfirmPassword($confirm_password);
                $this->UserModel->validator();
                if ($this->UserModel->validationPassed()) {
                    $new_password = password_hash($new_password, PASSWORD_DEFAULT);
                    $id = User::currentUser()->id;
                    $this->UserModel->update($id, ['password' => $new_password]);
                    Router::redirect('profile/index');
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
        $current_user = User::$currentLoggedInUser;
        if ($this->request->isPost()) {
            $this->request->csrfCheck();
            if ($this->request->get('email') != '') {
                $current_user->email = $this->request->get('email');
                $current_user->confirmed = 0;
                $emailExists = $this->UserModel->findByEmail($this->request->get('email'));
                if ($emailExists) {
                    $this->view->user = $current_user;
                    $this->view->validationMessages = ['email' => 'Email address exists in our records'];
                    $this->view->render('profile/updateEmail');
                }
                $current_user->sendConfirmation();
            }
            $current_user->notification = (array_key_exists('notification', $this->request->get())) ? 1 : 0;
            if ($current_user->save() && $this->request->get('email') != '') {
                User::currentUser()->logout();
                Router::redirect('login');
            } else {
                Router::redirect('profile');
            }
        }
        $this->view->user = $current_user;
        $this->view->render('profile/updateEmail');
    }

    public function deleteAccountAction() {
        $currentUser = User::currentUser();
        if ($this->request->isPost()) {
            $passwordVerified = password_verify($this->request->get('password'), $currentUser->password);
            if ($passwordVerified) {
                $currentUser->logout();
                $currentUser->delete();
                Router::redirect('login');
            } else {
                $this->view->validationMessages = ['password' => 'Invalid password'];
            }
        }
        $this->view->user = $currentUser;
        $this->view->render('profile/deleteAccount');
    }

    protected function _isNotificationChecked($notification) {
        if (isset($notification) && $notification == 'on') {
            return 1;
        }
        return 0;
    }
}