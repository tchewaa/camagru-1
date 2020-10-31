<?php
    namespace App\Models;
    use Core\Model;
    use Core\Validators\RequiredValidator;
    use \Exception;

class Login extends Model {
  public $username, $password, $remember_me;

  public function __construct(){
    parent::__construct('tmp_fake');
  }

  public function validator(){
      try {
          $this->runValidation(new RequiredValidator($this, ['field' => 'username', 'msg' => 'Username is required.']));
          $this->runValidation(new RequiredValidator($this,['field'=>'password','msg'=>'Password is required.']));
      } catch (Exception $e) {
          echo $e->getMessage();
      }
  }

  public function getRememberMeChecked(){
    return $this->remember_me == 'on';
  }
}
