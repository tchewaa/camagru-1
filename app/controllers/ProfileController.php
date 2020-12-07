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
        $this->load_model('Verification');
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
                $this->UserModel->setConfirm($confirm_password);
                $this->UserModel->validator();
                if ($this->UserModel->validationPassed()) {
                    $new_password = password_hash($new_password, PASSWORD_DEFAULT);
                    $id = User::currentUser()->id;
                    $this->UserMode->update($id, ['password' => $new_password]);
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
            $email = $this->request->get('email');
            $notification = $this->_getNotificationChecked($this->request->get('notification'));
//            $this->user->assign($this->request->get());
            $this->UserModel->assign($this->request->get());
//            $this->user->validator();
            $this->UserModel->validator();
            if ($this->UserModel->validationPassed()) {
                $emailExists = $this->UserModel->findByEmail($email);
                if (!$emailExists) {
                    $verification = $this->VerificationModel->findFirst([
                        'conditions' => 'user_id = ?',
                        'bind' => [$current_user->id]
                    ]);
                    Helper::dnd($emailExists);
                    if ($verification && $verification->sendVerificationToken($this->UsersModel)) {
                        $current_user->update($current_user->id, ['email' => $email, 'notification' => $notification]);
                        $verification->update($current_user->id, ['confirmed' => 0]);
                        $current_user->logout();
                        Router::redirect('login');
                    }
                } else {
                    $this->view->validationMessages = ['email' => 'Email address exists in our records'];
                }
            } else {
                echo 'failed';
                $this->view->validationMessages = $this->user->getErrorMessages();
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
                $temp = $this->UserModel->delete();
                Helper::dnd($temp);
                if ($this->UserModel->delete()) {
                    Helper::dnd("deleted");
                };
                Helper::dnd("deleting");
            } else {
                $this->view->validationMessages = ['password' => 'Invalid password'];
            }
        }
        $this->view->user = $currentUser;
        $this->view->render('profile/deleteAccount');
    }

    protected function _getNotificationChecked($notification) {
        if ($notification == 'on') {
            return 1;
        }
        return 0;
    }
}