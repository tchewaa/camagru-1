<?php


namespace App\Controllers;


use App\Models\Users;
use Core\Controller;
use Core\Helpers;
use Core\Router;

class GalleryController extends Controller {

    public function __construct($controller, $action){
        parent::__construct($controller, $action);
        $this->load_model('Images');
        $this->view->setLayout('default');
    }

    public function indexAction() {
        //TODO create index page for profile
        $this->view->render('gallery/index');
    }

    public function uploadAction() {
        $newDims = ['x' => 640, 'y' => 480];
        Helpers::dnd($this->request->get());
        if ($_POST['hidden_data'] != '' || $_POST['hidden_data'] != null){
            $this->getFrame($_POST['hidden_top']);
            $image = $_POST['hidden_data'];
            $img_str = base64_decode(explode(',', $image)[1]);
            $type = explode('/', explode(';', explode(',', $image)[0])[0])[1];
            $img_src = imagecreatefromstring($img_str);
            $x_size = imagesx($img_src);
            $y_size = imagesy($img_src);
            $new_img = imagecreatetruecolor($newDims['x'], $newDims['y']);
            imagecopyresampled($new_img, $img_src, 0, 0, 0, 0, $newDims['x'], $newDims['y'], $x_size, $y_size);
            if ($_POST['hidden_top'] && Helpers::sanitize($_POST['hidden_top']) != '') {
                $frame = $this->getFrame($_POST['hidden_top']);
                $x_size = imagesx($frame);
                $y_size = imagesy($frame);
                imagecopyresampled($new_img, $frame, 0, 0, 0, 0, $newDims['x'] / 4, $newDims['y'] / 4, $x_size, $y_size);
                imagedestroy($frame);
            }
            ob_start();
            imagejpeg($new_img, NULL, 100);
            $data = ob_get_clean();
            $data = base64_encode($data);
            imagedestroy($new_img);
            imagedestroy($img_src);
            $this->_saveImage($data);
        } else {
            Router::redirect('gallery');
        }
        
    }

    public function getFrame($src) {
        $newFrame = imagecreatefrompng($src);
        return $newFrame;
    }

    private function _saveImage($data) {
//        $imageSaver = new Image();
        $type = 'data:image/jpeg;base64, ';
        $data = $type . $data;
        $this->ImagesModel->upload($data, Users::currentUser()->username . time());
    }
}