<?php

namespace Core;

class H
{

    public static function dnd($data) // Используется для отладки и вывода информации о переменной.
    {
        echo "<pre>";
        var_dump($data);
        echo "</pre>";
        die();
    }

    public static function currentPage() // Возвращает URL текущей страницы.
    {
        $currentPage = $_SERVER['REQUEST_URI'];
        if ($currentPage == PROOT || $currentPage == PROOT . 'home/index') {
            $currentPage = PROOT . 'home';
        }
        return $currentPage;
    }

    public static function getObjProperties($obj) // Возвращает все свойства объекта.
    {
        return get_object_vars($obj);
    }
}
