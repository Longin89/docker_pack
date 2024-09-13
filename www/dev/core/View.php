<?php

namespace Core;

class View
{
    protected $_head, $_header, $_body, $_footer, $_siteTitle = SITE_TITLE, $_outputBuffer, $_layout = DEFAULT_LAYOUT;

    public function __construct() {}

    public function render($viewName) // Рендерит конкретный шаблон и его соответствующий макет.
    {
        $viewArr = explode('/', $viewName);
        $viewString = implode(DS, $viewArr);
        if (file_exists(ROOT . DS . 'app' . DS . 'views' . DS . $viewString . '.php')) {
            require_once(ROOT . DS . 'app' . DS . 'views' . DS . $viewString . '.php');
            require_once(ROOT . DS . 'app' . DS . 'views' . DS . 'layouts' . DS . $this->_layout . '.php');
        } else {
            die("The view {$viewName} does not exist");
        }
    }

    public function content($type) // Возвращает содержимое определенного типа (head, header, body или footer).
    {
        if ($type == 'head') {
            return $this->_head;
        } elseif ($type == 'header') {
            return $this->_header;
        } elseif ($type == 'body') {
            return $this->_body;
        } elseif ($type == 'footer') {
            return $this->_footer;
        }

        return false;
    }

    public function start($type) // Используется для буферизации вывода определенных частей страницы.
    {
        $this->_outputBuffer = $type;
        ob_start();
    }

    public function end() // // Используется для буферизации вывода определенных частей страницы.
    {
        if ($this->_outputBuffer == 'head') {
            $this->_head = ob_get_clean();
        } elseif ($this->_outputBuffer == 'header') {
            $this->_header = ob_get_clean();
        } elseif ($this->_outputBuffer == 'body') {
            $this->_body = ob_get_clean();
        } elseif ($this->_outputBuffer == 'footer') {
            $this->_footer = ob_get_clean();
        } else {
            die('You must start method');
        }
    }

    public function siteTitle() // Позволяет получить заголовок сайта.
    {
        return $this->_siteTitle;
    }

    public function setSiteTitle($title) // Позволяет установить заголовок сайта.
    {
        $this->_siteTitle = $title;
    }

    public function setLayout($path) // Позволяет задать путь к макету страницы.
    {
        $this->_layout = $path;
    }

    public function insert($path) // Включает отдельный файл вида в текущий контекст.
    {
        include_once ROOT . DS . 'app' . DS . 'views' . DS . $path . '.php';
    }

    public function partial($group, $partial) // Включает частичный шаблон из группы частей.
    {
        include_once ROOT . DS . 'app' . DS . 'views' . DS . $group . DS . 'partials' . DS . $partial . '.php';
    }
}
