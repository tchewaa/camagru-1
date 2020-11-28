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
        $this->view->comments = $this->CommentsModel->getComments($imageId);
        $this->view->render('home/image');
    }

    public function likeAction() {
        $imageId = '';
        if ($this->request->isPost()) {
            $imageId .= $this->request->get('image-id');
            $likeStatus = $this->request->get('like-status');
            if ($likeStatus === 'like') {
                $this->ImagesModel->likeImage($imageId);
            } elseif ($likeStatus === 'unlike') {
                $this->ImagesModel->unlikeImage($imageId);
            }
        }
    }

    public function commentAction() {
        $imageId = '';
        if ($this->request->isPost()) {
            $this->request->csrfCheck();
            $comment = $this->request->get('comment');
            $imageId .= $this->request->get('image-id');
            $saveComment = $this->CommentsModel->comment($comment, $imageId);
            //TODO handle comment validation message
//            if (isset($saveComment['content'])) {
//                Helper::dnd($saveComment['content']);
//            } else {
//                Helper::dnd("Comment saved");
//            }
        }
    }
}