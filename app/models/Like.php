<?php


namespace App\Models;

use Core\Helper;
use Core\Model;

class Like extends Model {
    public $id;
    public $user_id;
    public $image_id;

    public function __construct(){
        $table = 'likes';
        parent::__construct($table);
    }

    public function likeImage($imageAuthor) {
        $currentUser = User::currentUser();
        $this->image_id = $imageAuthor->id;
        $this->user_id = $currentUser->id;
        if ($this->save()) {
            if ($imageAuthor->notification === 1 && $currentUser->id != $imageAuthor->user_id) {
                $this->_sendLikeEmail($imageAuthor);
            }
        } else {
            return false;
        }
        return true;
    }

    public function unlikeImage($imageId) {
        $userId = User::currentUser()->id;
        $sql = "DELETE FROM `likes` WHERE user_id = ? AND image_id = ?";
        $params = [$userId, $imageId];
        return $this->query($sql, $params);
    }

    public function likedImage($image, $user) {
        $sql = "SELECT user_id, image_id FROM `likes` WHERE user_id = ? AND image_id = ?";
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