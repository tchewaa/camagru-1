<?php


namespace App\Controllers;


use App\Models\Auth;
use App\Models\Users;
use App\Models\Verification;
use Core\Controller;
use Core\FormHelper;
use Core\Helper;
use Core\Router;

class LoginController extends Controller {

    public function __construct($controller, $action){
        parent::__construct($controller, $action);
        $this->load_model('Users');
        $this->load_model('Auth');
        $this->load_model('Verification');
        $this->view->setLayout('default');
    }

    public function indexAction() {
        if ($this->request->isPost()) {
            $this->request->csrfCheck();
            $this->AuthModel->assign($this->request->get());
            $user = $this->UsersModel->findByUsername($_POST['username']);
            $this->AuthModel->validator();
            if ($this->AuthModel->validationPassed() && $user){
                $passwordVerified = password_verify($this->request->get('password'), $user->password);
                if ($user->confirmed == 0) {
                    $this->AuthModel->addErrorMessage('username','Please confirm your email before you login');
                } elseif (!$passwordVerified) {
                    $this->AuthModel->addErrorMessage('username','There is an error with your username or password');
                }  else {
                    $remember = $this->AuthModel->getRememberMeChecked();
                    $user->login($remember);
                    Router::redirect('');
                }
            } else {
                $this->AuthModel->addErrorMessage('username','There is an error with your username or password');
            }
        }
        $this->view->user = $this->AuthModel;
        $this->view->validationMessages = $this->AuthModel->getErrorMessages();
        $this->view->render('login/index');
    }

    public function forgotPasswordAction() {
        if ($this->request->isPost()) {
            $this->request->csrfCheck();
            $user = $this->UsersModel->findByEmail($this->request->get('email'));
            if ($user && $user->forgotPasswordToken()) {
                Router::redirect('login');
            } else {
                $this->view->validationMessages = ['email' => 'Email doesn\'t not exists in our records'];
            }
        }
        $this->view->render('login/forgotPassword');
    }

    public function resetPasswordAction($username = "", $token = "") {
        if ($username && $token) {
            if ($this->request->isPost()) {
                $this->request->csrfCheck();
                $this->UsersModel->assign($this->request->get());
                $this->UsersModel->setConfirmPassword($this->request->get('confirmPassword'));
                $this->UsersModel->validator();
                if ($this->UsersModel->validationPassed()) {
                    $user = $this->UsersModel->findByUsername($username);
                    $user->password = password_hash($this->request->get("password"), PASSWORD_DEFAULT);
                    $user->save();
                    Router::redirect('login');
                } else {
                    $this->view->validationMessages = $this->UsersModel->getErrorMessages();
                }
            }
            $this->view->render('login/resetPassword');
        } else {
            Router::redirect('restricted');
        }
    }
}