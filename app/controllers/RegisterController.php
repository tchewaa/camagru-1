<?php
namespace App\Controllers;
use App\Models\Verification;
use Core\Controller;
use Core\Helpers;
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
            $this->UsersModel->setConfirm($this->request->get('confirm'));
            if($this->UsersModel->save()){
                $this->_sendConfirmation($this->UsersModel);
                //$this->view->validationMessages = ['success' => "Testing success message"];
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
            $this->UsersModel->assign($this->request->get());
            $this->UsersModel->validator();
            if ($this->UsersModel->validationPassed()) {
                $user = $this->UsersModel->findByEmail($this->request->get("email"));
                if ($user && $this->_resendToken($user)) {
                    Router::redirect('login');
                } else {
                    $this->view->validationMessages = ['email' => 'Email doesn\'t not exists in our records'];
                }
            } else {
                $this->view->validationMessages = $this->UsersModel->getErrorMessages();
            }
        }
        $this->view->render('register/resendToken');
    }

    public function verifyAction($username = "", $token = "") {
        if ($username && $token) {
            $user = $this->UsersModel->findByUsername($username);
            $verification= $this->VerificationModel->findByUserId($user->id);
            if ($verification != null) {
                $verification->confirmed = 1;
                $verification->save();
                Router::redirect('login');
            } else {
                //TODO redirect and display the error
                echo "Something went wrong";

            }
        } else {
            //TODO redirect and display the error
            echo "Something went wrong";
        }
    }
}
