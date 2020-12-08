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
        $table = 'images';
        parent::__construct($table);
    }

    public function upload($file, $name) {
        $user = User::currentUser();
        $this->user_id = $user->id;
        $this->image_name = $name;
        $this->image_data = $file;
        return $this->save();
    }

    public function findUserImages($userId) {
        $sql = "SELECT * FROM images WHERE user_id = ? ORDER BY `date` DESC";
        $params = [$userId];
        $this->query($sql, $params);
        return $this->_db->results();
    }

    public function findImages() {
        $sql = "SELECT * FROM images ORDER BY `date` ASC ";
        $this->query($sql);
        return $this->_db->results();
    }

    public function findImage($imageId = '') {
        $sql = "
            SELECT
                i.id,
                i.user_id,
                i.image_data,
                i.date,
                u.username
            FROM images i, user u 
            WHERE i.id = ? AND u.id = i.user_id";
        $params = [$imageId];
        $this->query($sql, $params);
        return $this->_db->first();
    }

    public function imageCount() {
        return count($this->findImages());
    }

    public function pageCount() {
        return ceil($this->imageCount() / PAGE_SIZE);
    }
}