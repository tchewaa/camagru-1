<?php

namespace App\Controllers;

use App\Models\Users;
use Core\Controller;
use Core\Router;

class LikeController extends Controller {
    public function __construct($controller, $action) {
        parent::__construct($controller, $action);
        $this->load_model('Likes');
        $this->view->setLayout('default');
    }

    public function indexAction() {
        Router::redirect('home');
    }

    public function updateAction() {
        echo 'Image liked: ' . $this->request->get('image-id');
        echo ' Liked by: ' . Users::currentUser()->id;
        return $this->LikesModel->updateLike();
//        $this->view->render('home/image/24');
//        Router::redirect('home');
    }
}