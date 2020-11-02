<?php
namespace App\Models;
use Core\Helpers;
use Core\Model;
use Core\Validators\RequiredValidator;

class Login extends Model {
    public $username, $password, $email, $remember_me;

    public function __construct(){
        parent::__construct('tmp_fake');
    }

    public function validator() {
        if (isset($this->username)) {
            $this->runValidation(new RequiredValidator($this,['field'=>'username','msg'=>'Username is required.']));
        } elseif (isset($this->password)) {
            $this->runValidation(new RequiredValidator($this,['field'=>'password','msg'=>'Password is required.']));
        } elseif (isset($this->email)) {
            $this->runValidation(new RequiredValidator($this,['field'=>'email','msg'=>'Email is required.']));
        }
    }

    public function getRememberMeChecked(){
    return $this->remember_me == 'on';
    }
}
