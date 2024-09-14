<?php

namespace Core;

use Core\Session;
use App\Models\Users;

class Router
{
  public static function route($url) // Яляется ключевым методом класса и отвечает за маршрутизацию URL,определяет контроллер и действие на основе URL, проверяет права доступа, обрабатывает запрос.
  {

    // controller
    $controller = (isset($url[0]) && $url[0] != '') ? ucwords($url[0] . 'Controller') : DEFAULT_CONTROLLER . 'Controller';
    $controller_name = str_replace('Controller', '', $controller);
    array_shift($url);

    // action
    $action = (isset($url[0]) && $url[0] != '') ? $url[0] . 'Action' : 'indexAction';
    $action_name = (isset($url[0]) && $url[0] != '') ? $url[0] : '';
    array_shift($url);

    // acl check
    $grantAccess = self::hasAccess($controller_name, $action_name);
    if (!$grantAccess) {
      $controller = ACCESS_RESTRICTED . 'Controller';
      $controller_name = ACCESS_RESTRICTED;
      $action = 'indexAction';
    }

    $queryParams = $url;
    $controller = 'App\Controllers\\' . $controller;

    $dispatch = new $controller($controller_name, $action);

    if (method_exists($controller, $action)) {
      call_user_func_array([$dispatch, $action], $queryParams);
    } else {
      die("Method doesn't exist:" . $controller_name);
    }
  }

  public static function redirect($location) // Используется для перенаправления пользователя на другую страницу.
  {
    if (!headers_sent()) {
      header('Location: ' . PROOT . $location);
      exit();
    } else {
      echo '<script type="text/javascript">';
      echo 'window.location.href="' . PROOT . $location . '";';
      echo '</script>';
      echo '<noscript>';
      echo '<meta http-equiv="refresh" content="0;url=' . $location . '" />';
      echo '</noscript>';
      exit;
    }
  }

  public static function hasAccess($controller_name, $action_name = 'index') // Проверяет права доступа пользователя к определенному контроллеру и действию.
  {
    $acl_file = file_get_contents(ROOT . DS . 'app' . DS . 'acl.json');
    $acl = json_decode($acl_file, true);
    $current_user_acls = ['Guest'];
    $grantAccess = false;

    if (Session::exists(CURRENT_USER_SESSION_NAME)) {
      $current_user_acls[] = 'LoggedIn';
      foreach (Users::currentUser()->acls() as $a) {
        $current_user_acls[] = $a;
      }
    }
    foreach ($current_user_acls as $level) {
      if (array_key_exists($level, $acl) && array_key_exists($controller_name, $acl[$level])) {
        if (in_array($action_name, $acl[$level][$controller_name]) || in_array("*", $acl[$level][$controller_name])) {
          $grantAccess = true;
          break;
        }
      }
    }

    // check for denied
    foreach ($current_user_acls as $level) {
      $denied = $acl[$level]['denied'];
      if (!empty($denied) && array_key_exists($controller_name, $denied) && in_array($action_name, $denied[$controller_name])) {
        $grantAccess = false;
        break;
      }
    }
    return $grantAccess;
  }

  public static function getMenu($menu) // Генерирует меню на основе данных из JSON-файла.
  {
    $menuArr = [];
    $menuFile = file_get_contents(ROOT . DS . 'app' . DS . $menu . '.json');
    $acl = json_decode($menuFile, true);
    foreach ($acl as $key => $value) {
      if (is_array($value)) {
        $sub = [];
        foreach ($value as $k => $v) {
          if ($k == 'separator' && !empty($sub)) {
            $sub[$k] = '';
            continue;
          } else if ($finalValue = self::get_link($v)) {
            $sub[$k] = $finalValue;
          }
        }
        if (!empty($sub)) {
          $menuArr[$key] = $sub;
        }
      } else {
        if ($finalValue = self::get_link($value)) {
          $menuArr[$key] = $finalValue;
        }
      }
    }
    return $menuArr;
  }

  private static function get_link($value) // Используется для генерации ссылок в меню.
  {
    if (preg_match('/https?:\/\//', $value) == 1) {
      return $value;
    } else {
      $uArr = explode('/', $value);
      $controller_name = ucwords($uArr[0]);
      $action_name = (isset($uArr[1])) ? $uArr[1] : '';
      if (self::hasAccess($controller_name, $action_name)) {
        return PROOT . $value;
      }
      return false;
    }
  }
}
