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
        $loginModel = new Login();
        if ($this->request->isPost()) {
            $this->request->csrfCheck();
            $loginModel->assign($this->request->get());
            $loginModel->validator();
            if ($loginModel->validationPassed()) {
                $email = FormHelper::sanitize($this->request->get('email'));
                $user = $this->UsersModel->findByEmail($email);
                if ($user && $this->_forgotPasswordToken($user)) {
                    Router::redirect('login');
//                    return;
                } else {
                    $this->view->validationMessages = ['email' => 'Email doesn\'t not exists in our records'];
                }
            } else {
                $this->view->validationMessages = $loginModel->getErrorMessages();
            }
        }
        $this->view->render('login/forgotPassword');
    }

    public function resetPasswordAction($username = "", $token = "") {
        if ($username && $token) {
            if ($this->request->isPost()) {
                $this->request->csrfCheck();
                $user = $this->UsersModel->findByUsername($username);
                //check if user exists
                //get token
                $verification = new Verification();
                //TODO Refactor
                $verification = $verification->findFirst([
                    'conditions' => 'user_id = ?',
                    'bind' => [$user->id]
                ]);
                //TODO refactor
                //validate token
                if ($verification->confirmation_token == $token) {
                    $user->password = password_hash(FormHelper::sanitize($_POST['password']), PASSWORD_DEFAULT);
                    //update password
                    if ($user->save()) {
                        Router::redirect('login');
                    }
                }
            }
            $this->view->render('login/resetPassword');
        } else {
            Router::redirect('restricted');
        }
    }
}