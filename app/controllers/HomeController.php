<?php
  namespace App\Controllers;
  use Core\Controller;
  use Core\H;
  use App\Models\Users;
  use Core\Helper;
  use Core\Router;

class HomeController extends Controller {

    public function __construct($controller, $action) {
        parent::__construct($controller, $action);
        $this->load_model('Images');
        $this->view->setLayout('default');
    }

    public function indexAction($page = 1) {
        $this->view->page = $page;
        $images = array_slice(array_reverse($this->ImagesModel->getImages()), ($this->view->page - 1) * PAGE_SIZE, PAGE_SIZE);
//        Helper::dnd($images);
        $this->view->images = $images;
        $this->view->pageCount = $this->ImagesModel->pageCount();
//        $this->view->images = $this->ImagesModel->getImages();
        $this->view->render('home/index');
    }

    public function logoutAction() {
        if(Users::currentUser()) {
            Users::currentUser()->logout();
        }
        Router::redirect('login');
    }

    public function imageAction($imageId = '') {
        $this->view->image = $this->ImagesModel->getImage($imageId);
        $this->view->render('home/image');
    }
}
