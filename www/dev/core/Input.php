<?php

namespace Core;

use Core\FH;
use Core\Router;

class Input
{

    public function isPost() // Использует getRequestMethod() для получения метода запроса.
    {
        return $this->getRequestMethod() === 'POST';
    }

    public function isPut() // Использует getRequestMethod() для получения метода запроса.
    {
        return $this->getRequestMethod() === 'PUT';
    }

    public function isGet() // Использует getRequestMethod() для получения метода запроса.
    {
        return $this->getRequestMethod() === 'GET';
    }

    public function getRequestMethod() // Возвращает метод запроса.
    {
        return strtoupper($_SERVER['REQUEST_METHOD']);
    }

    public function get($input = false) // метод получает входные данные, если передан аргумент, возвращает значение конкретного поля.
    {
        if (!$input) {
            $data = [];
            foreach ($_REQUEST as $field => $value) {
                $data[$field] = FH::sanitize($value);
            }
            return $data;
        }
        return FH::sanitize($_REQUEST[$input]);
    }

    public function csrfCheck() // Проверяет CSRF-токен.
    {
        if (!FH::checkToken($this->get('csrf_token'))) Router::redirect('restricted/badToken');
        return true;
    }
}
