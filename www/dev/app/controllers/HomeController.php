<?php

namespace App\Controllers;

use Core\Controller;


class HomeController extends Controller
{
    public function __construct($controller, $action) // Вызывает родительский конструктор, передавая ему текущий контроллер и действие.
    {
        parent::__construct($controller, $action);
    }

    public function indexAction() // Отвечает за отображение домашней страницы приложения. Использует объект $this->view для рендеринга представления
    {
        $this->view->render('home/index');
    }
}
