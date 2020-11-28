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
            //TODO refactor
            $image = new Images();
            $image = $image->findById($imageId);
            $imageAuthor = new Users($image->user_id);
            if ($imageAuthor->notification === 1 && $currentUser->id != $image->user_id) {
                $this->_sendCommentEmail($imageAuthor);
            }
        }
        return $this->getErrorMessages();
    }

    private function _sendCommentEmail($imageAuthor) {
        $headers = Helper::getHeaders();
        $subject = 'Camagru: Comment made your image';
        $message = Helper::formatImageCommentMessage($imageAuthor);
        if (mail($imageAuthor->email, $subject, $message, $headers)) return true;
    }

    public function getComments($imageId) {
        return $this->findComments($imageId);
    }

    public function validator() {
        $this->runValidation(new MinValidator($this, ['field' => 'content', 'rule' => 1, 'msg' => 'Comment must at least have 1 character']));
        $this->runValidation(new MaxValidator($this, ['field' => 'content', 'rule' => 255, 'msg' => 'Comment cannot be more that 255 characters']));
    }

}