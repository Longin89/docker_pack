<?php

namespace App\Models;

use Core\Model;
use Core\Validators\RequiredValidator;


class Login extends Model
{
    public $username, $password, $remember_me;

    public function __construct() // Вызывает родительский конструктор, передавая ему имя временной таблицы 'tmp_fake'. 
    {
        parent::__construct('tmp_fake');
    }

    public function validator() // Определяет правила валидации для полей username и password, Оба поля обязательны для заполнения.
    {
        $this->runValidation(new RequiredValidator($this, ['field' => 'username', 'msg' => 'Username is required']));
        $this->runValidation(new RequiredValidator($this, ['field' => 'password', 'msg' => 'Password is required']));
    }

    public function getRememberMeChecked() // Проверяет, был ли отмечен чекбокс "Запомнить меня" во время входа. Возвращает true, если значение $remember_me равно 'on'.
    {
        return $this->remember_me == 'on';
    }
}
