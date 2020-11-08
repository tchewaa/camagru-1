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
        $this->view->setLayout('default');
    }

    public function indexAction() {
        $this->view->render('register/index');
    }

    public function registerUserAction() {
        if($this->request->isPost()) {
            $newUser = new Users();
            $this->request->csrfCheck();
            $newUser->assign($this->request->get());
            $newUser->setConfirm($this->request->get('confirm'));
            if($newUser->save()){
                $this->_sendConfirmation($newUser);
                //$this->view->validationMessages = ['success' => "Testing success message"];
              Router::redirect('login');
            }
        }
        $this->view->user = $newUser;
        $this->view->validationMessages = $newUser->getErrorMessages();
        $this->view->render('register/index');
    }

    public function resendTokenAction() {
        if ($this->request->isPost()) {
            $user = new Users();
            $this->request->csrfCheck();
            $user->assign($this->request->get());
            $user->validator();
            if ($user->validationPassed()) {
                $u = $user->findByEmail($user->email);
                if ($u && $this->_resendToken($u)) {
                    Router::redirect('login');
                } else {
                    $this->view->validationMessages = ['email' => 'Email doesn\'t not exists in our records'];
                }
            } else {
                $this->view->validationMessages = $user->getErrorMessages();
            }
        }
        $this->view->render('register/resendToken');
    }

    public function verifyAction($username = "", $token = "") {
        if ($username && $token) {
            $user = new Users($username);
            $verificationToken = new Verification();
            $verificationToken = $verificationToken->findByUserId($user->id);
            if ($verificationToken != null) {
                $verificationToken->confirmed = 1;
                $verificationToken->save();
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
