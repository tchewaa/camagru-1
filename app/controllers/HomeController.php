<?php
  namespace App\Controllers;
  use Core\Controller;
  use Core\H;
  use App\Models\User;
  use Core\Helper;
  use Core\Router;

class HomeController extends Controller {

    public function __construct($controller, $action) {
        parent::__construct($controller, $action);
        $this->load_model('Image');
        $this->load_model('Like');
        $this->load_model('Comment');
        $this->view->setLayout('default');
    }

    public function indexAction($page = 1) {
        $this->view->page = $page;
        $images = array_slice(array_reverse($this->ImageModel->findImages()), ($this->view->page - 1) * PAGE_SIZE, PAGE_SIZE);
        $this->view->images = $images;
        $this->view->pageCount = $this->ImageModel->pageCount();
        $this->view->render('home/index');
    }

    public function logoutAction() {
        if(User::currentUser()) {
            User::currentUser()->logout();
        }
        Router::redirect('login');
    }

}