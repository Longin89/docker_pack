<?php

namespace Core;

class Application
{
    public function __construct() //  Вызывает приватный метод _set_reporting(), который настраивает параметры отладки и логирования ошибок.
    {
        $this->_set_reporting();
    }

    private function _set_reporting() // Режим работы отладчика в зависимости от состояния константы DEBUG.
    {
        if (DEBUG) {
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
        } else {
            error_reporting(0);
            ini_set('display_errors', 0);
            ini_set('log_errors', 1);
            ini_set('error.log', ROOT . DS . 'tmp' . DS . 'logs' . DS . 'errors.log');
        }
    }
}
