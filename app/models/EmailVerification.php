<?php


namespace App\Models;


use Core\FormHelper;
use Core\Helpers;
use Core\Model;

class EmailVerification extends Model {
    public $id;
    public $user_id;
    public $confirmation_token;
    public $confirmed;


    public function __construct(){
        $table = 'email_verification';
        parent::__construct($table);
    }

    public function sendVerificationToken($fields) {
        $headers = Helpers::getHeaders();
        $subject = 'Camagru account confirmation';
        $user = new Users($fields->username);
        $params = ['user_id' => $user->id];
        $this->assign($params);
        $this->confirmed = 0;
        $this->user_id = $user->id;
        $this->confirmation_token = md5($user->first_name . $user->email . Helpers::generateRandomString());
        $this->save();
        $message = Helpers::formatEmailMessage($this->confirmation_token, $user);
        mail($fields->email, $subject, $message, $headers);
    }

}