<?php
namespace App\Controllers;
use App\Models\Verification;
use Core\Controller;
use Core\Helper;
use Core\Router;
use App\Models\Users;
use App\Models\Auth;

class RegisterController extends Controller {

    public function __construct($controller, $action) {
        parent::__construct($controller, $action);
        $this->load_model('Users');
        $this->load_model('Verification');
        $this->view->setLayout('default');
    }

    public function indexAction() {
        $this->view->render('register/index');
    }

    public function registerUserAction() {
        if($this->request->isPost()) {
            $this->request->csrfCheck();
            $this->UsersModel->assign($this->request->get());
            $this->UsersModel->token = md5(Helper::generateRandomString());
            $this->UsersModel->setConfirmPassword($this->request->get('confirmPassword'));
            if($this->UsersModel->save()){
                $this->UsersModel->sendConfirmation();
              Router::redirect('login');
            }
        }
        $this->view->user = $this->UsersModel;
        $this->view->validationMessages = $this->UsersModel->getErrorMessages();
        $this->view->render('register/index');
    }

    public function resendTokenAction() {
        if ($this->request->isPost()) {
            $this->request->csrfCheck();
            $user = $this->UsersModel->findByEmail($this->request->get("email"));
            if ($user && $user->sendConfirmation($user)) {
                Router::redirect('login');
            } else {
                $this->view->validationMessages = ['email' => 'Email doesn\'t not exists in our records'];
            }
        }
        $this->view->render('register/resendToken');
    }

    public function verifyAction($username = "", $token = "") {
        if ($username && $token) {
            $user = $this->UsersModel->findByUsername($username);
            if ($user) {
                $user->confirmed = 1;
                $user->save();
                Router::redirect('login');
            }
        } else {
            $this->view->validationMessages = ['email' => 'Invalid token'];
        }
    }
}
