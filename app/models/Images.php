<?php


namespace App\Models;


use Core\Helper;
use Core\Model;

class Images extends Model {
    public $id;
    public $user_id;
    public $image_name;
    public $image_data;
    public $date;

    public function __construct(){
        $table = 'images';
        parent::__construct($table);
    }

    public function upload($file, $name) {
        $user = Users::currentUser();
        $this->user_id = $user->id;
        $this->image_name = $name;
        $this->image_data = $file;
        return $this->save();
    }

    public function getUserImages() {
        $user = Users::currentUser();
        $images = $this->userImages($user->id);
        return $images;
    }

    public function getImages() {
        return $this->images();
    }

    public function getImage($imageId = '') {
        return $this->getImageById($imageId);
    }

    public function imageCount() {
        return count($this->getImages());
    }

    public function pageCount() {
        return ceil($this->imageCount() / PAGE_SIZE);
    }

    public function likeImage($imageId) {
        $image = $this->findById($imageId);
        $imageLike = new Likes();
        $imageLike = $imageLike->uploadLike($image);
        if ($imageLike) return true;
        return false;
    }

    public function unlikeImage($imageId) {
        $userId = Users::currentUser()->id;
        $likedImage = new Likes();
        $likedImage->deleteLike($imageId, $userId);
    }
}