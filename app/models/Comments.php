<?php


namespace App\Models;


use Core\Helper;
use Core\Model;
use Core\Validators\MaxValidator;
use Core\Validators\MinValidator;

class Comments extends Model {
    public $id;
    public $user_id;
    public $image_id;
    public $content;

    public function __construct(){
        $table = 'comments';
        parent::__construct($table);
    }

    public function comment($comment, $imageId) {
        $currentUser = Users::currentUser();
        $this->user_id = $currentUser->id;
        $this->image_id = $imageId;
        $this->content = $comment;
        if ($this->save()) {
            Helper::dnd($this->getErrorMessages());
        }
    }

    public function validator() {
        $this->runValidation(new MinValidator($this, ['field' => 'content', 'rule' => 1, 'msg' => 'Comment must at least have 1 character']));
        $this->runValidation(new MaxValidator($this, ['field' => 'content', 'rule' => 255, 'msg' => 'Comment cannot be more that 255 characters']));
    }

}