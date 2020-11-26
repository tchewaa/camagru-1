<?php


namespace App\Models;


use Core\FormHelper;
use Core\Helper;
use Core\Model;

class Verification extends Model {
    public $id;
    public $user_id;
    public $token;
    public $confirmed;

    public function __construct(){
        $table = 'verification';
        parent::__construct($table);
    }

    public function sendVerificationToken($fields) {
        $headers = Helper::getHeaders();
        $subject = 'Camagru account confirmation';
        $user = new Users($fields->username);
        //TODO check if user exists
        //TODO investigate
//        $params = [
//            'user_id' => $user->id,
//        ];
//        $this->assign($params); //
        $this->confirmed = 0;
        $this->user_id = $user->id;
        $this->token = md5($user->username . $user->email . Helper::generateRandomString());
        $message = Helper::formatConfirmationMessage($this->token, $user);
        //TODO check if token was saved
        if ($this->save() && mail($fields->email, $subject, $message, $headers)) {
            return true;
        }
        return false;
    }


    //TODO move to helpers
    public function resendVerificationToken($user, $token) {
        $headers = Helper::getHeaders();
        $subject = 'Camagru: Account confirmation';
        $message = Helper::formatConfirmationMessage($token, $user);
        if (mail($user->email, $subject, $message, $headers)) return true;
        return false;
    }

    public function sendForgotPasswordToken($user, $token) {
        $headers = Helper::getHeaders();
        $subject = 'Camagru: Forgot your password?';
        $message = Helper::formatForgotPasswordMessage($token, $user);
        if (mail($user->email, $subject, $message, $headers)) return true;
    }

}