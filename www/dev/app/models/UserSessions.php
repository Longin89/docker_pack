<?php

namespace App\Models;

use Core\Model;
use Core\Session;
use Core\Cookie;

class UserSessions extends Model
{
    public $id, $user_id, $session, $user_agent;

    public function __construct() // Устанавливает имя таблицы 'user_sessions' и вызывает родительский конструктор для инициализации модели.
    {
        $table = 'user_sessions';
        parent::__construct($table);
    }

    public static function getFromCookie() // Забирает сессию пользователя из ''user_sessions, если она существует.
    {
        $userSession = new self();
        if (Cookie::exists(REMEMBER_ME_COOKIE_NAME)) {
            $userSession = $userSession->findFirst([
                'conditions' => "user_agent = ? AND session = ?",
                'bind' => [Session::uagent_no_version(), Cookie::get(REMEMBER_ME_COOKIE_NAME)]
            ]);
        }
        if (!$userSession) return false;
        return $userSession;
    }
}
