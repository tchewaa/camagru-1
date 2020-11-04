<?php
namespace App\Models;
use Core\Helpers;
use Core\Model;
use App\Models\UserSession;
use Core\Cookie;
use Core\Session;
use Core\Validators\MinValidator;
use Core\Validators\MaxValidator;
use Core\Validators\PasswordValidator;
use Core\Validators\RequiredValidator;
use Core\Validators\EmailValidator;
use Core\Validators\MatchesValidator;
use Core\Validators\UniqueValidator;

class Users extends Model {
    private $_isLoggedIn = false;
    private $_sessionName;
    private $_cookieName;
    private $_confirm;
    public static $currentLoggedInUser = null;
    public $id;
    public $username;
    public $email;
    public $password;
    public $new_password;
    public $notification = 1;

    public function __construct($user='') {
        $table = 'users';
        parent::__construct($table);
        $this->_sessionName = CURRENT_USER_SESSION_NAME;
        $this->_cookieName = REMEMBER_ME_COOKIE_NAME;
        $this->_softDelete = true;
        if($user != '') {
          if(is_int($user)) {
            $u = $this->_db->findFirst('users',['conditions'=>'id = ?', 'bind'=>[$user]],'App\Models\Users');
          } else {
            $u = $this->_db->findFirst('users', ['conditions'=>'username = ?','bind'=>[$user]],'App\Models\Users');
          }
          if($u) {
            foreach($u as $key => $val) {
              $this->$key = $val;
            }
          }
        }
    }

    public function beforeSave(){
        if($this->isNew()){
          $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        }
    }

    public static function currentUser() {
        if(!isset(self::$currentLoggedInUser) && Session::exists(CURRENT_USER_SESSION_NAME)) {
          $u = new Users((int)Session::get(CURRENT_USER_SESSION_NAME));
          self::$currentLoggedInUser = $u;
        }
        return self::$currentLoggedInUser;
    }

    public function login($rememberMe=false) {
        Session::set($this->_sessionName, $this->id);
        if($rememberMe) {
          $hash = md5(uniqid() + rand(0, 100));
          $user_agent = Session::uagent_no_version();
          Cookie::set($this->_cookieName, $hash, REMEMBER_ME_COOKIE_EXPIRY);
          $fields = ['session'=>$hash, 'user_agent'=>$user_agent, 'user_id'=>$this->id];
          $this->_db->query("DELETE FROM user_sessions WHERE user_id = ? AND user_agent = ?", [$this->id, $user_agent]);
          $this->_db->insert('user_sessions', $fields);
        }
    }

    public static function loginUserFromCookie() {
        $userSession = UserSession::getFromCookie();
        if($userSession && $userSession->user_id != '') {
          $user = new self((int)$userSession->user_id);
          if($user) {
            $user->login();
          }
          return $user;
        }
        return null;
    }

    public function logout() {
        $userSession = UserSession::getFromCookie();
        if($userSession) $userSession->delete();
        Session::delete(CURRENT_USER_SESSION_NAME);
        if(Cookie::exists(REMEMBER_ME_COOKIE_NAME)) {
          Cookie::delete(REMEMBER_ME_COOKIE_NAME);
        }
        self::$currentLoggedInUser = null;
        return true;
    }

    public function acls() {
        if(empty($this->acl)) return [];
        return json_decode($this->acl, true);
    }

    public function validator() {
        $this->_checkUsername();
        $this->_checkEmail();
        $this->_checkPassword();
    }

    protected function _checkUsername() {
        if (isset($this->username)) {
            $this->runValidation(new MinValidator($this,['field'=>'username','rule'=>4,'msg'=>'Username must be at least 4 characters.']));
            $this->runValidation(new RequiredValidator($this,['field'=>'username','msg'=>'Username is required.']));
            $this->runValidation(new UniqueValidator($this,['field'=>'username','msg'=>'That username already exists.']));
            $this->runValidation(new MaxValidator($this,['field'=>'username','rule'=>50,'msg'=>'Username must be less than 150 characters.']));
        }
    }

    protected function _checkEmail() {
        if (isset($this->email)) {
            $this->runValidation(new RequiredValidator($this,['field'=>'email','msg'=>'Email is required.']));
            $this->runValidation(new EmailValidator($this, ['field'=>'email','msg'=>'You must provide a valid email address']));
            $this->runValidation(new MaxValidator($this,['field'=>'email','rule'=>150,'msg'=>'Your email address cannot be more that 150 characters']));
            $this->runValidation(new UniqueValidator($this,['field'=>'email','msg'=>'That email already exists.']));
        }
    }

    protected function _checkPassword() {
        if (isset($this->password)) {
            $this->runValidation(new MinValidator($this,['field'=>'password','rule'=>6,'msg'=>'Password must be a minimum of 6 characters']));
            $this->runValidation(new PasswordValidator($this,['field'=>'password','rule'=>$this->password,'msg'=>"Password must contain Uppercase, Lowercase, Number and special character."]));
            $this->runValidation(new RequiredValidator($this,['field'=>'password','msg'=>'Password is required.']));
            if($this->isNew()){
                $this->runValidation(new MatchesValidator($this,['field'=>'password','rule'=>$this->_confirm,'msg'=>"Your passwords do not match"]));
            }
        }
    }

    public function setConfirm($value){
        $this->_confirm = $value;
    }

    public function getConfirm(){
        return $this->_confirm;
    }

    public function getIsLoggedIn(){
        return $this->_isLoggedIn;
    }

    public function setIsLoggedIn($isLoggedIn){
        $this->_isLoggedIn = $isLoggedIn;
    }

}
