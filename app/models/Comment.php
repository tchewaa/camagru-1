<?php


namespace App\Models;


use Core\Helper;
use Core\Model;
use Core\Validators\MaxValidator;
use Core\Validators\MinValidator;

class Comment extends Model {
    public $id;
    public $user_id;
    public $image_id;
    public $content;

    public function __construct(){
        $table = 'comments';
        parent::__construct($table);
    }

    public function uploadComment($comment, $imageId) {
        $currentUser = User::currentUser();
        $this->user_id = $currentUser->id;
        $this->image_id = $imageId;
        $this->content = $comment;
        if ($this->save()) {
            $imageAuthor = new User($this->user_id);
            if ($imageAuthor->notification === 1 && $currentUser->id != $this->user_id) {
                $this->_sendCommentEmail($imageAuthor);
            }
        }
        return $this->getErrorMessages();
    }

    public function findComments($imageId) {
        $sql = "
            SELECT 
                c.user_id, 
                c.image_id, 
                c.content,
                c.date,
                u.username 
            FROM comments c, user u 
            WHERE c.image_id = ? AND u.id = c.user_id
            ORDER BY `date` DESC";
        $params = [$imageId];
        $this->query($sql, $params);
        return $this->_db->results();
    }

    private function _sendCommentEmail($imageAuthor) {
        $headers = Helper::getHeaders();
        $subject = 'Camagru: Comment made your image';
        $message = Helper::formatImageCommentMessage($imageAuthor);
        if (mail($imageAuthor->email, $subject, $message, $headers)) return true;
    }

    public function validator() {
        $this->runValidation(new MinValidator($this, ['field' => 'content', 'rule' => 1, 'msg' => 'Comment must at least have 1 character']));
        $this->runValidation(new MaxValidator($this, ['field' => 'content', 'rule' => 255, 'msg' => 'Comment cannot be more that 255 characters']));
    }

}