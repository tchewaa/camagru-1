<?php

namespace App\Controllers;

use App\Models\User;
use Core\Controller;
use Core\Helper;
use Core\Router;

class EditorController extends Controller {

    public function __construct($controller, $action){
        parent::__construct($controller, $action);
        $this->load_model('Image');
        $this->view->setLayout('default');
    }

    public function indexAction() {
        //TODO create index page for profile
        $this->view->userImages = $this->ImageModel->findUserImages(User::currentUser()->id);
        $this->view->render('editor/index');
    }

    //TODO handle validation
    public function uploadAction() {
        
        if (isset($_POST['webCamImage'])) {
            //webcam image
            $base64Image = $_POST['webCamImage'];
            $base64Image = str_replace('data:image/png;base64,','',$base64Image);
            $imageBinary = base64_decode($base64Image);
            $image = imagecreatefromstring($imageBinary);

            if ($_POST['selectedStickers']) {
                //TODO Refactor _applyStickers($image, $stickers);
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
                        imagecopyresized($image, $stickerImage, 420, 0, 0, 0, $stickerWidth, $stickerHeight, $width, $height);
                    }

                    if ($key == 2) {
                        imagecopyresized($image, $stickerImage, 0, 280, 0, 0, $stickerWidth, $stickerHeight, $width, $height);
                    }

                    if ($key == 3) {
                            imagecopyresized($image, $stickerImage, 420, 280, 0, 0, $stickerWidth, $stickerHeight, $width, $height);
                    }
                }
            }
            ob_start();
            //TODO use jpeg
            imagepng($image);
            $imageData = ob_get_clean();
            $imageData = base64_encode($imageData);
            $base64Image = 'data:image/' . 'png' . ';base64,' . $imageData;
            $this->_saveImage($base64Image);
            $this->view->render('editor/index');
        } elseif (isset($_FILES) && isset($_FILES['image-upload'])) {
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
                echo "<meta http-equiv='refresh' content='0'>";
            } else {
                $this->view->validationMessages = ["upload-error" => "Something went wrong while uploading your image, please try again later"];
                echo "<meta http-equiv='refresh' content='0'>";
            }
        }
        $this->view->userImages = $this->ImageModel->findUserImages(User::currentUser()->id);
        $this->view->render('editor/index');
    }

    public function deleteAction() {
        if ($this->request->isPost()) {
            $userID = User::currentUser()->id;
            $imageID = $this->request->get("image-id");
            if ($this->ImageModel->delete($imageID)) {
                echo "image deleted";
            }
        }
        $this->view->userImages = $this->ImageModel->findUserImages(User::currentUser()->id);
        $this->view->render('editor/index');
    }

    public function getFrame($src) {
        $newFrame = imagecreatefrompng($src);
        return $newFrame;
    }

    private function _saveImage($image) {
        return $this->ImageModel->upload($image, User::currentUser()->username . time());
    }
}