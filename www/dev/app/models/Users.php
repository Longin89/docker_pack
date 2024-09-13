<?php

namespace App\Models;

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

class Users extends Model
{
    private $_isLoggedIn, $_sessionName, $_cookieName, $_confirm;
    public static $currentLoggedUser = null;
    public $id, $username, $email, $password, $fname, $lname, $acl, $deleted = 0;

    public function __construct($user = '') // Устанавливает имя таблицы, настройки для сессий и куков, включает мягкое удаление и может инициализировать пользователя по ID или имени.
    {
        $table = 'users';
        parent::__construct($table);
        $this->_sessionName = CURRENT_USER_SESSION_NAME;
        $this->_cookieName = REMEMBER_ME_COOKIE_NAME;
        $this->_softDelete = true;
        if ($user != '') {
            if (is_int($user)) {
                $u = $this->_db->findFirst('users', ['conditions' => 'id = ?', 'bind' => [$user]], 'App\Models\Users');
            } else {
                $u = $this->_db->findFirst('users', ['conditions' => 'username = ?', 'bind' => [$user]], 'App\Models\Users');
            }
            if ($u) {
                foreach ($u as $key => $val) {
                    $this->$key = $val;
                }
            }
        }
    }

    public function validator() // Определяет правила валидации для различных полей модели.
    {
        $this->runValidation(new RequiredValidator($this, ['field' => 'fname', 'msg' => 'First Name is required']));
        $this->runValidation(new RequiredValidator($this, ['field' => 'lname', 'msg' => 'Last Name is required']));
        $this->runValidation(new RequiredValidator($this, ['field' => 'email', 'msg' => 'Email is required']));
        $this->runValidation(new EmailValidator($this, ['field' => 'email', 'msg' => 'Correct email is required']));
        $this->runValidation(new MinValidator($this, ['field' => 'username', 'rule' => 4, 'msg' => 'Username must be at least 4 chars']));
        $this->runValidation(new MaxValidator($this, ['field' => 'username', 'rule' => 10, 'msg' => 'Username must be 10 chars maximum']));
        $this->runValidation(new UniqueValidator($this, ['field' => 'username', 'msg' => 'This username already exists']));
        $this->runValidation(new UniqueValidator($this, ['field' => 'email', 'msg' => 'This email already exists']));
        $this->runValidation(new RequiredValidator($this, ['field' => 'password', 'msg' => 'Password is required']));
        $this->runValidation(new MinValidator($this, ['field' => 'password', 'rule' => 4, 'msg' => 'Password must be at least 4 chars']));
        if ($this->isNew()) {
            $this->runValidation(new MatchesValidator($this, ['field' => 'password', 'rule' => $this->_confirm, 'msg' => 'Password mismatch']));
        }
    }

    public function beforeSave() // Хэширует пароль перед сохранением нового пользователя.
    {
        if ($this->isNew()) {
            $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        }
    }

    public function findByUsername($username) // Находит пользователя по имени пользователя.
    {
        return $this->findFirst(['conditions' => "username = ?", 'bind' => [$username]]);
    }

    public static function currentUser() //Возвращает текущего аутентифицированного пользователя.
    {
        if (!isset(self::$currentLoggedUser) && Session::exists(CURRENT_USER_SESSION_NAME)) {
            $U = new Users((int)Session::get(CURRENT_USER_SESSION_NAME));
            self::$currentLoggedUser = $U;
        }
        return self::$currentLoggedUser;
    }

    public function login($rememberMe = false) // Логинит пользователя, устанавливая сессию и куки при необходимости.
    {
        Session::set($this->_sessionName, $this->id);
        if ($rememberMe) {
            $randomNumber = rand(0, 1000);
            $hash = md5(uniqid() . $randomNumber);
            $user_agent = Session::uagent_no_version();
            Cookie::set($this->_cookieName, $hash, REMEMBER_ME_COOKIE_EXPIRE);
            $fields = ['session' => $hash, 'user_agent' => $user_agent, 'user_id' => $this->id];
            $this->_db->query("DELETE FROM user_sessions WHERE user_id = ? AND user_agent = ?", [$this->id, $user_agent]);
            $this->_db->insert('user_sessions', $fields);
        }
    }

    public static function loginUserFromCookie() // Пытается залогинить пользователя из cookie.
    {
        $userSession = UserSessions::getFromCookie();
        if ($userSession && $userSession->user_id != '') {
            $user = new self((int)$userSession->user_id);
            if ($user) {
                $user->login();
            }
            return $user;
        }
        return;
    }

    public function logout() // Выполняет выход пользователя из системы.
    {
        $userSession = UserSessions::getFromCookie();
        if ($userSession) $userSession->delete();
        Session::delete(CURRENT_USER_SESSION_NAME);
        if (Cookie::exists(REMEMBER_ME_COOKIE_NAME)) {
            Cookie::delete(REMEMBER_ME_COOKIE_NAME);
        }
        self::$currentLoggedUser = null;
        return true;
    }

    public function acls() // Возвращает список прав доступа пользователя в виде массива.
    {
        if (empty($this->acl)) return [];
        return json_decode($this->acl, true);
    }

    public function setConfirm($value) // Устанавливает значение пароля.
    {
        $this->_confirm = $value;
    }

    public function getConfirm() // Получает значение пароля.
    {
        return $this->_confirm;
    }
}
