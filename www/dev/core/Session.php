<?php

namespace Core;

class Session
{

  public static function exists($name) // Проверяет, существует ли определенная переменная в сессии.
  {
    return (isset($_SESSION[$name])) ? true : false;
  }

  public static function get($name) // Возвращает значение определенной переменной из сессии.
  {
    return $_SESSION[$name];
  }

  public static function set($name, $value) // Устанавливает значение для определенной переменной в сессии.
  {
    return $_SESSION[$name] = $value;
  }

  public static function delete($name) // Удаляет определенную переменную из сессии.
  {
    if (self::exists($name)) {
      unset($_SESSION[$name]);
    }
  }

  public static function uagent_no_version() // Обрабатывает строку User-Agent, удаляя информацию о версии браузера.
  {
    $uagent = $_SERVER['HTTP_USER_AGENT'];
    $regx = '/\/[a-zA-Z0-9.]+/';
    $newString = preg_replace($regx, '', $uagent);
    return $newString;
  }

  public static function addMsg($type, $msg) // Используется для добавления уведомлений пользователю.
  {
    $sessionName = 'alert-' . $type;
    self::set($sessionName, $msg);
  }

  public static function displayMsg() // // Используется для отображения уведомлений пользователю.
  {
    $alerts = ['alert-info', 'alert-success', 'alert-warning', 'alert-danger'];
    $html = '';
    foreach ($alerts as $alert) {
      if (self::exists($alert)) {
        $html .= '<div class="alert ' . $alert . ' alert-dismissible" role="alert">';
        $html .= '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
        $html .= self::get($alert);
        $html .= '</div>';
        self::delete($alert);
      }
    }
    return $html;
  }
}
