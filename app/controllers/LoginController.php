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
        $this->load_model('Auth');
        $this->load_model('Verification');
        $this->view->setLayout('default');
    }

    public function indexAction() {
        //TODO create index page for login
        if ($this->request->isPost()) {
            $this->request->csrfCheck();
            $this->AuthModel->assign($this->request->get());
            $user = $this->UsersModel->findByUsername($_POST['username']);
            //TODO find a way to move validation to the model
            $this->AuthModel->validator();
            if ($this->AuthModel->validationPassed() && $user){
                //TODO find a way to use a Join technique instead of querying the database twice
                $verification = $this->VerificationModel->findFirst([
                    'conditions' => 'user_id = ?',
                    'bind' => [$user->id]
                ]);
                $passwordVerified = password_verify($this->request->get('password'), $user->password);
                if ($verification->confirmed == 0) {
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
            $auth = new Auth();
            $this->request->csrfCheck();
            $this->AuthModel->assign($this->request->get());
            $user = $this->UsersModel->findByEmail($this->request->get('email'));
            $auth->validator();
            if ($auth->validationPassed()) {
                if ($user && $this->_forgotPasswordToken($user)) {
                    Router::redirect('login');
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
            if ($this->request->isPost()) {
                $this->request->csrfCheck();
                $this->AuthModel->assign($this->request->get());
                $this->AuthModel->confirm_password = $this->request->get('confirm_password');
                $this->AuthModel->validator();
                if ($this->AuthModel->validationPassed()) {
                    $user = $this->UsersModel->findByUsername($username);
                    //TODO Refactor
                    if ($user) {
                        $verification = $this->VerificationModel->findFirst([
                            'conditions' => 'user_id = ?',
                            'bind' => [$user->id]
                        ]);
                        if ($verification->token === $token) {
                            $user->password = password_hash($this->request->get("password"), PASSWORD_DEFAULT);
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
                    $this->view->validationMessages = $this->AuthModel->getErrorMessages();
                }
            }
            $this->view->render('login/resetPassword');
        } else {
            Router::redirect('restricted');
        }
    }
}