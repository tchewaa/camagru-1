<?php
  namespace App\Controllers;
  use Core\Controller;
  use Core\H;
  use App\Models\Users;
  use Core\Router;

class HomeController extends Controller {

    public function __construct($controller, $action) {
      parent::__construct($controller, $action);
    }

    public function indexAction() {
      $this->view->render('home/home');
    }

    public function testAjaxAction(){
      $resp = ['success'=>true,'data'=>['id'=>23,'name'=>'Phetho','favorite_food'=>'bread']];
      $this->jsonResponse($resp);
    }

    public function logoutAction() {
      if(Users::currentUser()) {
          Users::currentUser()->logout();
      }
      Router::redirect('login');
    }
}
