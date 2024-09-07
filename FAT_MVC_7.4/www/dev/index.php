<?php

use Core\Session;
use Core\Cookie;
use Core\Router;
use App\Models\Users;

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__));

// Load conf
require_once(ROOT . DS . 'config' . DS . 'config.php');

function autoload($className)
{
    $classArr = explode('\\', $className);
    $class = array_pop($classArr);
    $subPath = strtolower(implode(DS, $classArr));
    $path = ROOT . DS . $subPath . DS . $class . '.php';
    if (file_exists($path)) {
        require_once($path);
    }
}

spl_autoload_register('autoload');
session_start();

$url = isset($_SERVER['PATH_INFO']) ? explode('/', ltrim($_SERVER['PATH_INFO'], '/')) : [];

if (!Session::exists(CURRENT_USER_SESSION_NAME) && Cookie::exists(REMEMBER_ME_COOKIE_NAME)) {
    Users::loginUserFromCookie();
}

Router::route($url);
