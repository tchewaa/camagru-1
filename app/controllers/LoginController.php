<?php


namespace App\Controllers;


use App\Models\Auth;
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
        $auth = new Auth();
        if($this->request->isPost()) {
            // form validation
            $this->request->csrfCheck();
            $auth->assign($this->request->get());
            $auth->validator();
            if($auth->validationPassed()){
                $user = $this->UsersModel->findByUsername($_POST['username']);
                //TODO Refactor
                if($user && password_verify($this->request->get('password'), $user->password)) {
                    $remember = $auth->getRememberMeChecked();
                    $user->login($remember);
                    Router::redirect('');
                }  else {
                    $auth->addErrorMessage('username','There is an error with your username or password');
                }
            }
        }
        $this->view->auth = $auth;
        $this->view->validationMessages = $auth->getErrorMessages();
        $this->view->render('login/login');
    }

    public function forgotPasswordAction() {
        $auth = new Auth();
        if ($this->request->isPost()) {
            $this->request->csrfCheck();
            $auth->assign($this->request->get());
            $auth->validator();
            if ($auth->validationPassed()) {
                $email = FormHelper::sanitize($this->request->get('email'));
                $user = $this->UsersModel->findByEmail($email);
                //TODO Refactor
                if ($user && $this->_forgotPasswordToken($user)) {
                    Router::redirect('login');
//                    return;
                } else {
                    $this->view->validationMessages = ['email' => 'Email doesn\'t not exists in our records'];
                }
            } else {
                $this->view->validationMessages = $auth->getErrorMessages();
            }
        }
        $this->view->render('login/forgotPassword');
    }

    public function resetPasswordAction($username = "", $token = "") {
        if ($username && $token) {
            $auth = new Auth();
            if ($this->request->isPost()) {
                $this->request->csrfCheck();
                $auth->assign($this->request->get());
                $auth->confirm_password = $this->request->get('confirm_password');
                $auth->validator();
                if ($auth->validationPassed()) {
                    $user = $this->UsersModel->findByUsername($username);
                    //TODO Refactor
                    //check if user exists
                    if ($user) {
                        //get token
                        $verification = new Verification();
                        $verification = $verification->findFirst([
                            'conditions' => 'user_id = ?',
                            'bind' => [$user->id]
                        ]);
                        //validate token
                        if ($verification->confirmation_token == $token) {
                            $user->password = password_hash(FormHelper::sanitize($_POST['password']), PASSWORD_DEFAULT);
                            //update password
                            $user->save();
                            Router::redirect('login');
                        } else {
                            $this->view->validationMessages = ['token' => 'Invalid token'];
                        }
                    } else {
                        $this->view->validationMessages = ['token' => 'Invalid token'];
                    }
                } else {
                    $this->view->validationMessages = $auth->getErrorMessages();
                }
            }
            $this->view->render('login/resetPassword');
        } else {
            Router::redirect('restricted');
        }
    }
}