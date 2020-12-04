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
        $images = array_slice(array_reverse($this->ImageModel->getImages()), ($this->view->page - 1) * PAGE_SIZE, PAGE_SIZE);
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

    public function imageAction($imageId = '') {
        //TODO join table
        $image = $this->ImageModel->getImage($imageId);
        $imageLiked = $this->LikeModel->likedImage($image, User::currentUser());
        if ($imageLiked->results()) {
            $imageLiked = true;
        } else {
            $imageLiked = false;
        }
        $this->view->image = $image;
        $this->view->imageLiked = $imageLiked;
        $this->view->comments = $this->CommentModel->getComments($imageId);
        $this->view->render('home/image');
    }

    public function likeAction() {
        $imageId = '';
        if ($this->request->isPost()) {
            $imageId .= $this->request->get('image-id');
            $likeStatus = $this->request->get('like-status');
            if ($likeStatus === 'like') {
                $this->ImageModel->likeImage($imageId);
            } elseif ($likeStatus === 'unlike') {
                $this->ImageModel->unlikeImage($imageId);
            }
        }
    }

    public function commentAction() {
        if ($this->request->isPost()) {
            $comment = $this->request->get('comment');
            $imageId = $this->request->get('image-id');
            $saveComment = $this->CommentModel->comment($comment, $imageId);
            //TODO handle comment validation message
//            if (isset($saveComment['content'])) {
//                Helper::dnd($saveComment['content']);
//            } else {
//                Helper::dnd("Comment saved");
//            }
        }
    }
}