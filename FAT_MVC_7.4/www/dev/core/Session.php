<?php

namespace Core;

class Session
{

  public static function exists($name)
  {
    return (isset($_SESSION[$name])) ? true : false;
  }

  public static function get($name)
  {
    return $_SESSION[$name];
  }

  public static function set($name, $value)
  {
    return $_SESSION[$name] = $value;
  }

  public static function delete($name)
  {
    if (self::exists($name)) {
      unset($_SESSION[$name]);
    }
  }

  public static function uagent_no_version()
  {
    $uagent = $_SERVER['HTTP_USER_AGENT'];
    $regx = '/\/[a-zA-Z0-9.]+/';
    $newString = preg_replace($regx, '', $uagent);
    return $newString;
  }

  /**
   * Adds a session alert message
   * @method addMsg
   * @param  string $type can be info, success, warning or danger
   * @param  string $msg  the message you want to display in the alert
   */

  public static function addMsg($type, $msg)
  {
    $sessionName = 'alert-' . $type;
    self::set($sessionName, $msg);
  }

  public static function displayMsg()
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
