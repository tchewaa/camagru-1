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
        $this->load_model('Likes');
        $this->load_model('Comments');
        $this->view->setLayout('default');
    }

    public function indexAction($page = 1) {
        $this->view->page = $page;
        $images = array_slice(array_reverse($this->ImagesModel->getImages()), ($this->view->page - 1) * PAGE_SIZE, PAGE_SIZE);
        $this->view->images = $images;
        $this->view->pageCount = $this->ImagesModel->pageCount();
        $this->view->render('home/index');
    }

    public function logoutAction() {
        if(Users::currentUser()) {
            Users::currentUser()->logout();
        }
        Router::redirect('login');
    }

    public function imageAction($imageId = '') {
        $image = $this->ImagesModel->getImage($imageId);
        $imageLiked = $this->LikesModel->likedImage($image, Users::currentUser());
        if ($imageLiked->results()) {
            $imageLiked = true;
        } else {
            $imageLiked = false;
        }
        $this->view->image = $image;
        $this->view->imageLiked = $imageLiked;
        $this->view->render('home/image');
    }

    public function likeAction() {
        $imageId = '';
        //check if data was posted
        if ($this->request->isPost()) {
            $imageId .= $this->request->get('image-id');
            $imageLiked = $this->ImagesModel->likeImage($imageId);
            if ($imageLiked) {
                //send success message
                echo "Like updated";
            } else {
                echo "something went wrong";
                //send error message
            }
        }
        $this->view->image = $this->ImagesModel->getImage($imageId);
        $this->view->render('home/image');
    }

    public function commentAction() {
        //check if data was posted
        if ($this->request->isPost()) {
            $comment = $this->CommentsModel->comment($this->request->get('comment'), $this->request->get('image-id'));
        }
        Helper::dnd("commenting on image Id: " . $this->request->get('image-id') . "\n" . "Comment: " . $this->request->get('comment'));
    }
}
