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
        $this->view->userImages = $this->GalleryModel->getUserImages();
        $this->view->render('gallery/index');
    }

    //TODO handle validation
    public function uploadAction() {
        
        if (isset($_POST['webCamImage'])) {
            //webcam image
            $base64Image = $_POST['webCamImage'];
            $base64Image = str_replace('data:image/png;base64,','',$base64Image);
            $imageBinary = base64_decode($base64Image);
            $image = imagecreatefromstring($imageBinary);
            $imageWidth = imagesx($image);
            $imageHeight = imagesx($image);

            if ($_POST['selectedStickers']) {
                //stickers 
                $stickers = $_POST['selectedStickers'];
                $stickerWidth = 80;
                $stickerHeight = 80;
                $stickers = explode(',', $stickers);
                foreach ($stickers as $key => $value) {
                    $stickerName = explode('/', $stickers[$key]);
                    $stickerPath = ROOT . '/app/assets/stickers/' . $stickerName[5];
                    $stickerImage = imagecreatefrompng($stickerPath);
                    list($width, $height) = getimagesize($stickerPath);
                    if ($key == 0) {
                        imagecopyresized($image, $stickerImage, 0, 0, 0, 0, $stickerWidth, $stickerHeight, $width, $height);        
                    }

                    if ($key == 1) {
                        $postionX = $imageWidth - $stickerWidth;
                        imagecopyresized($image, $stickerImage, 420, 0, 0, 0, $stickerWidth, $stickerHeight, $width, $height);        
                    }

                    if ($key == 2) {
                        $postionY = $imageHeight - $stickerHeight;
                        imagecopyresized($image, $stickerImage, 0, 280, 0, 0, $stickerWidth, $stickerHeight, $width, $height);        
                    }

                    if ($key == 3) {
                        $postionY = $imageHeight - $stickerHeight;
                            imagecopyresized($image, $stickerImage, 420, 280, 0, 0, $stickerWidth, $stickerHeight, $width, $height);        
                    }
                }
            }
            ob_start();
            imagepng($image);
            $imageData = ob_get_clean();
            $imageData = base64_encode($imageData);
            $base64Image = 'data:image/' . 'png' . ';base64,' . $imageData;
            $this->_saveImage($base64Image);
            $this->view->render('gallery/index');
        } elseif (isset($_FILES) && isset($_FILES['image-upload'])) {
//            $imageName = $_FILES['image-upload']['name'];
//            $imageType = pathinfo($imageName, PATHINFO_EXTENSION);
            $imageData = file_get_contents($_FILES['image-upload']['tmp_name']);
            if ($imageData) {
                $imageData = imagecreatefromstring($imageData);
                ob_start();
                imagejpeg($imageData);
                $imageData = ob_get_clean();
                $imageData = base64_encode($imageData);
                $base64Image = 'data:image/' . 'jpeg' . ';base64,' . $imageData;
                $this->view->validationMessages = ["upload-success" => "Image uploaded.."];
                $this->_saveImage($base64Image);
            } else {
                $this->view->validationMessages = ["upload-error" => "Something went wrong while uploading your image, please try again later"];
            }
        }
        $this->view->userImages = $this->GalleryModel->getUserImages();
        $this->view->render('gallery/index');
    }

    public function deleteAction() {
        if ($this->request->isPost()) {
            $userID = Users::currentUser()->id;
            $imageID = $this->request->get("image-id");
            if ($this->GalleryModel->delete($imageID)) {
                echo "image deleted";
            }
        }
        $this->view->userImages = $this->GalleryModel->getUserImages();
        $this->view->render('gallery/index');
    }

    public function getFrame($src) {
        $newFrame = imagecreatefrompng($src);
        return $newFrame;
    }

    private function _saveImage($image) {
        return $this->GalleryModel->upload($image, Users::currentUser()->username . time());
    }
}