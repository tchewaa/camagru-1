<?php
  namespace App\Controllers;
  use Core\Controller;
  use Core\H;
  use App\Models\Users;
  use Core\Helpers;
  use Core\Router;

class HomeController extends Controller {

    public function __construct($controller, $action) {
        parent::__construct($controller, $action);
        $this->load_model('Images');
        $this->view->setLayout('default');
    }

    public function indexAction($page = 1) {
        $this->view->page = $page;
//        $images = array_slice(array_reverse($this->ImagesModel->getImages()), ($this->view->page - 1) * PAGE_SIZE, PAGE_SIZE);
//        Helpers::dnd($images);
        $this->view->images = $this->ImagesModel->getImages();
        $this->view->render('home/index');
    }

    public function logoutAction() {
        if(Users::currentUser()) {
            Users::currentUser()->logout();
        }
        Router::redirect('login');
    }
}
