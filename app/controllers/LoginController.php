<?php


namespace App\Controllers;


use App\Models\Login;
use App\Models\Users;
use App\Models\Verification;
use Core\Controller;
use Core\FormHelper;
use Core\Helpers;
use Core\Router;

class LoginController extends Controller {

    public function __construct($controller, $action){
        parent::__construct($controller, $action);
        $this->load_model('Users');
        $this->view->setLayout('default');
    }

    public function indexAction() {
        $loginModel = new Login();
        if($this->request->isPost()) {
            // form validation
            $this->request->csrfCheck();
            $loginModel->assign($this->request->get());
            $loginModel->validator();
            if($loginModel->validationPassed()){
                $user = $this->UsersModel->findByUsername($_POST['username']);
                if($user && password_verify($this->request->get('password'), $user->password)) {
                    $remember = $loginModel->getRememberMeChecked();
                    $user->login($remember);
                    Router::redirect('');
                }  else {
                    $loginModel->addErrorMessage('username','There is an error with your username or password');
                }
            }
        }
        $this->view->login = $loginModel;
        $this->view->validationMessages = $loginModel->getErrorMessages();
        $this->view->render('login/login');
    }

    public function forgotPasswordAction() {
        if ($this->request->isPost()) {
            $this->request->csrfCheck();
            $email = FormHelper::sanitize($this->request->get('email'));
            $user = $this->UsersModel->findByEmail($email);
            if ($this->_forgotPasswordToken($user)) {
                Router::redirect('login');
            }
        }
        $this->view->render('login/forgotPassword');
    }

    public function resetPasswordAction($username = "", $token = "") {
        if ($username && $token) {
            if ($this->request->isPost()) {
                $this->request->csrfCheck();
                $user = $this->UsersModel->findByUsername($username);
                //check token
                //validate input
                //update password
                echo 'passed';
            } else {
                echo 'failed';
            }
            $this->view->render('login/resetPassword');
        } else {
            Router::redirect('restricted');
        }
    }
}