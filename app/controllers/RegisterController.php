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



  public function indexAction() {
    $newUser = new Users();
    if($this->request->isPost()) {
      $this->request->csrfCheck();
      $newUser->assign($this->request->get());
      $newUser->setConfirm($this->request->get('confirm'));
      if($newUser->save()){
//        $this->_sendConfirmation($newUser);
        Router::redirect('login');
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
          Router::redirect('login/login');
      } else {
          //TODO display the error
          echo "Something went wrong";
      }
  }

  public function resendTokenAction() {
//      Router::redirect('register/login');
      if ($this->request->isPost()) {
          $user = new Users();
          $user->assign($this->request->get());
          $user = $user->findFirst([
              'conditions' => 'email = ?',
              'bind' => [$user->email]
          ]);
          $this->_resendToken($user);
      }
      $this->view->render('register/resendToken');
  }

  protected function _sendConfirmation($user) {
      $emailVerification = new EmailVerification();
      $emailVerification->sendVerificationToken($user);
  }

  protected function _resendToken($user) {
      if ($user) {
          $verification = new EmailVerification();
          $verification = $verification->findFirst([
              'conditions' => 'user_id = ?',
              'bind' => [$user->id]
          ]);
          if ($verification) {
              $verification->resendVerificationToken($user->email, $verification->confirmation_token);
          }
      }
  }
}
