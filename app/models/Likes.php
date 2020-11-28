<?php


namespace App\Models;

use Core\Helper;
use Core\Model;

class Likes extends Model {
    public $id;
    public $user_id;
    public $image_id;

    public function __construct(){
        $table = 'likes';
        parent::__construct($table);
    }

    public function updateLike() {
        echo ' Updating like';
//        Helper::dnd("Finally here");
    }

    public function upload($image) {
        $currentUser = Users::currentUser();
        $likedImage = $this->likedImage($image, $currentUser);
        if ($likedImage->count() > 0) {
            //unlike image
//            Helper::dnd("Image already liked");
        } else {
            $this->image_id = $image->id;
            $this->user_id = $currentUser->id;
            if ($this->save()) {
                $imageAuthor = new Users($image->user_id);
                if ($imageAuthor->notification === 1) {
                    $this->_sendLikeEmail($imageAuthor);
                }
            } else {
                return false;
            }
            return true;
        }
        return false;
    }

    public function likedImage($image, $user) {
        $sql = "SELECT user_id, image_id FROM likes WHERE user_id = ? AND image_id = ?";
        $params = [$user->id, $image->id];
        return $this->query($sql, $params);
    }

    private function _sendLikeEmail($imageAuthor) {
        $headers = Helper::getHeaders();
        $subject = 'Camagru: Image Liked';
        $message = Helper::formatImageLikeMessage($imageAuthor);
        if (mail($imageAuthor->email, $subject, $message, $headers)) return true;
    }

    private function _unlikeImage($imageId, $userId) {
        Helper::dnd('unlike image');
    }
}