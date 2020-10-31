<?php
    namespace App\Models;
    use Core\Helpers;
    use Core\Model;
    use App\Models\UserSessions;
    use Core\Cookie;
    use Core\Session;
    use Core\Validators\MinValidator;
    use Core\Validators\MaxValidator;
    use Core\Validators\RequiredValidator;
    use Core\Validators\EmailValidator;
    use Core\Validators\MatchesValidator;
    use Core\Validators\UniqueValidator;

class Users extends Model {
    public $id;
    public $username;
    public $email;
    public $password;
    public $first_name;
    public $last_name;
    public $acl;
    public $deleted = 0;

    private $_isLoggedIn;
    private $_sessionName;
    private $_cookieName;
    public static $currentLoggedInUser = null;
    private $_confirm;

    public function __construct($user = '') {
        $table = 'users';
        parent::__construct($table);
        $this->_sessionName = CURRENT_USER_SESSION_NAME;
        $this->_cookieName = REMEMBER_ME_COOKIE_NAME;
        $this->_softDelete = true;
        if ($user != '') {
            if (is_int($user)) {
                $u = $this->_db->findFirst($table, ['conditions'=>'id = ?', 'bind'=>[$user]], 'Users');
            } else {
                $u = $this->_db->findFirst($table, ['conditions'=>'username = ?', 'bind'=>[$user]], 'Users');
            }
            if ($u) {
                foreach ($u as $key => $val) {
                    $this->$key = $val;
                }
            }
        }
    }

    public function validator(){
        try {
            $this->runValidation(new RequiredValidator($this, ['field' => 'fname', 'message' => 'First Name is required.']));
            $this->runValidation(new RequiredValidator($this,['field'=>'lname','message'=>'Last Name is required.']));
            $this->runValidation(new RequiredValidator($this,['field'=>'email','message'=>'Email is required.']));
            $this->runValidation(new EmailValidator($this, ['field'=>'email','message'=>'You must provide a valid email address']));
            $this->runValidation(new MaxValidator($this,['field'=>'email','rule'=>150,'message'=>'Email must be less than 150 characters.']));
            $this->runValidation(new MinValidator($this,['field'=>'username','rule'=>6,'message'=>'Username must be at least 6 characters.']));
            $this->runValidation(new MaxValidator($this,['field'=>'username','rule'=>150,'message'=>'Username must be less than 150 characters.']));
            $this->runValidation(new UniqueValidator($this,['field'=>'username','message'=>'That username already exists. Please choose a new one.']));
            $this->runValidation(new RequiredValidator($this,['field'=>'password','message'=>'Password is required.']));
            $this->runValidation(new MinValidator($this,['field'=>'password','message'=>'Password must be a minimum of 6 characters']));
            if($this->isNew()){
                $this->runValidation(new MatchesValidator($this,['field'=>'password','rule'=>$this->_confirm,'msg'=>"Your passwords do not match"]));
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function beforeSave(){
        if($this->isNew()){
            $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        }
    }

    public function findByUsername($username) {
        return $this->findFirst(['conditions'=>'username = ?', 'bind'=>[$username]]);
    }

    public static function currentUser() {
        if (!isset(self::$currentLoggedInUser) && Session::exists(CURRENT_USER_SESSION_NAME)) {
            $user = new Users((int)Session::get(CURRENT_USER_SESSION_NAME));
            self::$currentLoggedInUser = $user;
        }
        return self::$currentLoggedInUser;
    }

    public function login($rememberMe = false) {
        Session::set($this->_sessionName, $this->id);
        if ($rememberMe) {
            $hash = md5(uniqid() . rand(0, 100));
            $user_agent = Session::uagent_no_version();
            Cookie::set($this->_cookieName, $hash, REMEMBER_ME_COOKIE_EXPIRY);
            $fields = ['session'=>$hash, 'user_agent'=>$user_agent, 'user_id'=>$this->id];
            $this->_db->query("DELETE FROM user_sessions WHERE user_id = ? AND user_agent = ?", [$this->id, $user_agent]);
            $this->_db->insert('user_sessions', $fields);
        }
    }

    public static function loginUserFromCookie() {
        $userSession = UserSessions::getFromCookie();
        if ($userSession && $userSession->user_id != '') {
            $user = new self((int)$userSession->user_id);
            if ($user) {
                $user->login();
            }
            return $user;
        }
        return null;
    }

    public function logout() {
        $userSession = UserSessions::getFromCookie();
        if ($userSession) $userSession->delete();
        Session::delete(CURRENT_USER_SESSION_NAME);
        if (Cookie::exists(REMEMBER_ME_COOKIE_NAME)) {
            Cookie::delete(REMEMBER_ME_COOKIE_NAME);
        }
        self::$currentLoggedInUser = null;
        return true;
    }

    public function registerNewUser($params) {
        $this->assign($params);
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        $this->save();
    }

    public function acls() {
        if (empty($this->acl)) return [];
        return json_decode($this->acls, true);
    }

    public function setConfirm($value){
        $this->_confirm = $value;
    }

    public function getConfirm(){
        return $this->_confirm;
    }
}