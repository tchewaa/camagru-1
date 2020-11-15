<?php


namespace App\Controllers;


use App\Models\Users;
use Core\Controller;
use Core\Helpers;
use Core\Router;

class GalleryController extends Controller {

    public function __construct($controller, $action){
        parent::__construct($controller, $action);
        $this->load_model('Gallery');
        $this->view->setLayout('default');
    }

    public function indexAction() {
        //TODO create index page for profile
        $this->view->render('gallery/index');
    }

    public function uploadAction() {
        
        if (isset($_POST['webCamImage'])) {
            //webcam image
            $base64Image = $_POST['webCamImage'];
            $base64Image = str_replace('data:image/png;base64,','',$base64Image);
            $imageBinary = base64_decode($base64Image);
            $image = imagecreatefromstring($imageBinary);

            if ($_POST['selectedStickers']) {
                //stickers 
                $stickers = $_POST['selectedStickers'];
                $stickers = explode(',', $stickers);
                foreach ($stickers as $key => $value) {
                    $stickerName = explode('/', $stickers[$key]);
                    $stickerPath = ROOT . '/app/assets/stickers/' . $stickerName[5];
                    $stickerImage = imagecreatefrompng($stickerPath);
                    if ($key == 0) {
                        list($width, $heigth) = getimagesize($stickerPath);
                        $newWidth = 80;
                        $newHeigth = 80;
                        imagecopyresized($image, $stickerImage, 0, 0, 0, 0, $newWidth, $newHeigth, $width, $heigth);        
                    }
                }
                // Helpers::dnd(count($stickers));

                // $stickerName = explode('/', $stickers[0]);
                // $stickerPath = ROOT . '/app/assets/stickers/' . $stickerName[5];
                // $stickerImage = imagecreatefrompng($stickerPath);
                // list($width, $heigth) = getimagesize($stickerPath);
                // $newWidth = 80;
                // $newHeigth = 80;
                // imagecopyresized($image, $stickerImage, 0, 0, 0, 0, $newWidth, $newHeigth, $width, $heigth);
            }
            ob_start();
            imagepng($image);
            $imageData = ob_get_clean();
            $imageData = base64_encode($imageData);
            $base64 = 'data:image/' . 'png' . ';base64,' . $imageData;
            echo $base64;       
        
        } elseif (isset($_FILES)) {
            $image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
            if ($this->_saveImage($image)) {
                echo "Image saved...";
            }
        }
    
        // Router::redirect('gallery');
    }

    public function getFrame($src) {
        $newFrame = imagecreatefrompng($src);
        return $newFrame;
    }

    private function _saveImage($image) {
        $type = 'data:image/jpeg;base64, ';
        $image = $type . $image;
        return $this->GalleryModel->upload($image, Users::currentUser()->username . time());
    }
}