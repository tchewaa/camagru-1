<?php


namespace App\Models;


use Core\Helpers;
use Core\Model;

class Images extends Model {
    public $id;
    public $user_id;
    public $image_name;
    public $image_data;

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

}