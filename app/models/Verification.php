<?php


namespace App\Models;


use Core\FormHelper;
use Core\Helpers;
use Core\Model;

class Verification extends Model {
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
        //TODO check if user exists
        //TODO investigate
//        $params = [
//            'user_id' => $user->id,
//        ];
//        $this->assign($params); //
        $this->confirmed = 0;
        $this->user_id = $user->id;
        $this->confirmation_token = md5($user->first_name . $user->email . Helpers::generateRandomString());
        $message = Helpers::formatConfirmationMessage($this->confirmation_token, $user);
        //TODO check if token was saved
        if ($this->save() && mail($fields->email, $subject, $message, $headers)) {
            return true;
        }
        return false;
    }


    //TODO move to helpers
    public function resendVerificationToken($user, $token) {
        $headers = Helpers::getHeaders();
        $subject = 'Camagru: Account confirmation';
        $message = Helpers::formatConfirmationMessage($token, $user);
        if (mail($user->email, $subject, $message, $headers)) return true;
        return false;
    }

    public function sendForgotPasswordToken($user, $token) {
        $headers = Helpers::getHeaders();
        $subject = 'Camagru: Forgot your password?';
        $message = Helpers::formatForgotPasswordMessage($token, $user);
        if (mail($user->email, $subject, $message, $headers)) return true;
        Helpers::dnd($message);
    }

}