<?php
    namespace App\Controllers;
    use Core\Controller;
    use Core\Helpers;
    use App\Models\Users;


class HomeController extends Controller {

    public function __construct($controller, $action){
        parent::__construct($controller, $action);
    }

    public function indexAction($name) {
        $this->view->render('home/index');
    }

    public function testAjaxAction(){
        $resp = ['success'=>true,'data'=>['id'=>23,'name'=>'Curtis','favorite_food'=>'bread']];
        $this->jsonResponse($resp);
    }
}