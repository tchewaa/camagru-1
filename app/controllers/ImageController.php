<?php


namespace App\Controllers;


use App\Models\User;
use Core\Controller;
use Core\Helper;
use Core\Router;

class ImageController extends Controller {

    public function __construct($controller, $action) {
        parent::__construct($controller, $action);
        $this->load_model('User');
        $this->load_model('Image');
        $this->load_model('Like');
        $this->load_model('Comment');
        $this->view->setLayout('default');
    }

    public function indexAction($imageId) {
        if (User::currentUser()) {
            $image = $this->ImageModel->findImage($imageId);
            $imageLiked = $this->LikeModel->likedImage($image, User::currentUser());
            if ($imageLiked->results()) {
                $imageLiked = true;
            } else {
                $imageLiked = false;
            }
            $this->view->image = $image;
            $this->view->imageLiked = $imageLiked;
            $this->view->comments = $this->CommentModel->findComments($imageId);
            $this->view->render('image/index');
        } else {
            //TODO flash a message
            Router::redirect('login');
        }
    }

    public function likeAction() {
        $imageId = '';
        if ($this->request->isPost()) {
            $imageId .= $this->request->get('image-id');
            $likeStatus = $this->request->get('like-status');
            $image = $this->ImageModel->findbyId($imageId);
            if ($likeStatus === 'like' && $image) {
                $this->LikeModel->likeImage($image);
            } elseif ($likeStatus === 'unlike' && $image) {
                $this->LikeModel->unlikeImage($imageId);
            }
        }
    }

    public function commentAction() {
        if ($this->request->isPost()) {
            $comment = $this->request->get('comment');
            $imageId = $this->request->get('image-id');
            $saveComment = $this->CommentModel->uploadComment($comment, $imageId);
            //TODO handle comment validation message
//            if (isset($saveComment['content'])) {
//                Helper::dnd($saveComment['content']);
//            } else {
//                Helper::dnd("Comment saved");
//            }
        }
    }

}