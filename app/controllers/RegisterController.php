<?php
namespace App\Controllers;
use App\Models\EmailVerification;
use Core\Controller;
use Core\Helpers;
use Core\Router;
use App\Models\Users;
use App\Models\Login;

class RegisterController extends Controller {

  public function __construct($controller, $action) {
    parent::__construct($controller, $action);
    $this->load_model('Users');
    $this->view->setLayout('default');
  }

  public function testSendMail() {
      $to_email = "phetomalope@gmail.com";
      $subject = "Simple EmailVerification Test via PHP";
      $body = "Hi, This is test email send by PHP Script";
      $headers = "From: pmalope@student.wethinkcode.co.za";

      if (mail($to_email, $subject, $body, $headers)) {
          echo "EmailVerification successfully sent to $to_email...";
      } else {
          echo "EmailVerification sending failed...";
      }
  }

  public function loginAction() {
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
    $this->view->displayErrors = $loginModel->getErrorMessages();
    $this->view->render('register/login');
  }

  public function logoutAction() {
    if(Users::currentUser()) {
      Users::currentUser()->logout();
    }
    Router::redirect('register/login');
  }

  public function registerAction() {
    $newUser = new Users();
    if($this->request->isPost()) {
      $this->request->csrfCheck();
      $newUser->assign($this->request->get());
      $newUser->setConfirm($this->request->get('confirm'));
      if($newUser->save()){
        $this->_sendConfirmation($newUser);
        Router::redirect('register/login');
      }
    }
    $this->view->newUser = $newUser;
    $this->view->displayErrors = $newUser->getErrorMessages();
    $this->view->render('register/register');
  }

  public function verifyAction($username, $token) {
      $user = new Users($username);
      $emailVerification = new EmailVerification();
      $emailVerification = $emailVerification->findFirst([
          'conditions' => 'user_id = ?',
          'bind' => [$user->id]
      ]);
      if ($emailVerification != null) {
          $emailVerification->confirmed = 1;
          $emailVerification->save();
          Router::redirect('register/login');
      } else {
          //TODO display the error
          echo "Something went wrong";
      }
  }

  protected function _sendConfirmation($user) {
      $verifyEmail = new EmailVerification();
      $verifyEmail->sendVerificationToken($user);
  }
}
