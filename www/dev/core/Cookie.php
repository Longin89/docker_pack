<?php

namespace Core;

class Cookie
{
    public static function set($name, $value, $expire) // Принимает имя куки, значение и время жизни в секундах.
    {
        if (setCookie($name, $value, time() + $expire, '/')) {
            return true;
        }
        return false;
    }

    public static function delete($name) // Устанавливает значение куки в пустую строку, устанавливает время жизни в прошлое (time() - 1), что приводит к немедленному удалению.
    {
        self::set($name, '', time() - 1);
    }


    public static function get($name) // Возвращает значение из массива $_COOKIE для указанного имени.
    {
        return $_COOKIE[$name];
    }

    public static function exists($name) // Возвращает true, если куки с указанным именем существуют в $_COOKIE.
    {
        return isset($_COOKIE[$name]);
    }
}
