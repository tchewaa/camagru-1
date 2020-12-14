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
        $image_query = 'INSERT INTO `images` (user_id, image_name, image_data) VALUES (?, ?, ?)';
        $this->query($image_query,[$user->id, $name, $file]);
        return $this->results();
        // $stmt->execute([$user->id, $name, $file]);
    }

    public function findUserImages($userId) {
        $sql = "SELECT * FROM images WHERE user_id = ? ORDER BY `date` DESC";
        $params = [$userId];
        $this->query($sql, $params);
        return $this->results();
    }

    public function findImages() {
        $sql = "SELECT * FROM images ORDER BY `date` ASC ";
        $this->query($sql);
        return $this->results();
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
        return $this->first();
    }

    public function findImageAuthor($imageId = '') {
        $sql = "
            SELECT
                i.id,
                i.user_id,
                u.username,
                u.email,
                u.notification
            FROM images i, user u 
            WHERE i.id = ? AND u.id = i.user_id";
        $params = [$imageId];
        $this->query($sql, $params);
        return $this->first();
    }

    public function imageCount() {
        return count($this->findImages());
    }

    public function pageCount() {
        return ceil($this->imageCount() / PAGE_SIZE);
    }
}