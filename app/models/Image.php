<?php


namespace App\Models;


use Core\Helper;
use Core\Model;

class Image extends Model {
    public $id;
    public $user_id;
    public $image_name;
    public $image_data;
    public $date;

    public function __construct(){
        $table = 'image';
        parent::__construct($table);
    }

    public function upload($file, $name) {
        $user = User::currentUser();
        $this->user_id = $user->id;
        $this->image_name = $name;
        $this->image_data = $file;
        return $this->save();
    }

    public function getUserImages() {
        $user = User::currentUser();
        $images = $this->userImages($user->id);
        return $images;
    }

    public function getImages() {
        //TODO get images and related Authors
        return $this->find();
//        return $this->images();
    }

    public function getImage($imageId = '') {
        return $this->findImage($imageId);
    }

    public function imageCount() {
        return count($this->getImages());
    }

    public function pageCount() {
        return ceil($this->imageCount() / PAGE_SIZE);
    }

    public function likeImage($imageId) {
        $image = $this->findById($imageId);
        $imageLike = new Like();
        $imageLike = $imageLike->uploadLike($image);
        if ($imageLike) return true;
        return false;
    }

    public function unlikeImage($imageId) {
        $userId = User::currentUser()->id;
        $likedImage = new Like();
        $likedImage->deleteLike($imageId, $userId);
    }

    public function deleteImage($imageId) {
        Helper::dnd("deleting images and related comments and likes");
    }
}