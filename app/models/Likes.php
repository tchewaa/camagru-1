<?php


namespace App\Models;

use Core\Helper;
use Core\Model;

class Likes extends Model {

    public function __construct(){
        $table = 'likes';
        parent::__construct($table);
    }

    public function updateLike() {
        echo ' Updating like';
//        Helper::dnd("Finally here");
    }
}