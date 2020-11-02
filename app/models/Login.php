<?php
namespace App\Models;
use Core\Helpers;
use Core\Model;
use Core\Validators\MatchesValidator;
use Core\Validators\MinValidator;
use Core\Validators\RequiredValidator;

class Login extends Model {
    public $username, $password, $email, $remember_me, $confirm_password;

    public function __construct(){
        parent::__construct('tmp_fake');
    }

    public function validator() {
        if (isset($this->username)) {
            $this->runValidation(new RequiredValidator($this,['field'=>'username','msg'=>'Username is required.']));
        } elseif (isset($this->password)) {
            $this->runValidation(new MinValidator($this,['field'=>'password','rule'=>6,'msg'=>'Password must be a minimum of 6 characters']));
            $this->runValidation(new MatchesValidator($this,['field'=>'password','rule'=>$this->confirm_password,'msg'=>"Your passwords do not match"]));
        } elseif (isset($this->email)) {
            $this->runValidation(new RequiredValidator($this,['field'=>'email','msg'=>'Email is required.']));
        }
    }

    public function getRememberMeChecked(){
    return $this->remember_me == 'on';
    }
}
