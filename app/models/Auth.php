<?php
namespace App\Models;
use Core\Helper;
use Core\Model;
use Core\Validators\MatchesValidator;
use Core\Validators\MinValidator;
use Core\Validators\PasswordValidator;
use Core\Validators\RequiredValidator;

class Auth extends Model {
    public $username, $password, $email, $remember_me, $confirm_password;

    public function __construct(){
        $table = 'users';
        parent::__construct($table);
    }

    public function validator() {
        if (isset($this->username)) {
            $this->runValidation(new RequiredValidator($this,['field'=>'username','msg'=>'Username is required.']));
        } elseif (isset($this->password)) {
            $this->runValidation(new MinValidator($this,['field'=>'password','rule'=>6,'msg'=>'Password must be a minimum of 6 characters']));
            $this->runValidation(new PasswordValidator($this,['field'=>'password','rule'=>$this->password,'msg'=>"Password must contain Uppercase, Lowercase, Number and special character."]));
            $this->runValidation(new MatchesValidator($this,['field'=>'password','rule'=>$this->confirm_password,'msg'=>"Your passwords do not match"]));
            $this->runValidation(new RequiredValidator($this,['field'=>'password','msg'=>'Password is required.']));
        } elseif (isset($this->email)) {
            $this->runValidation(new RequiredValidator($this,['field'=>'email','msg'=>'Email is required.']));
        }
    }

    public function getRememberMeChecked(){
        return $this->remember_me == 'on';
    }
}
