<?php

namespace App\Controllers;

use Core\Controller;

class RestrictedController extends Controller
{
    public function __construct($controller, $action) // Вызывает родительский конструктор, передавая ему текущий контроллер и действие.
    {
        parent::__construct($controller, $action);
    }

    public function indexAction() // Отвечает за отображение страницы ограниченного доступа. Использует объект $this->view для рендеринга 'restricted/index'.
    {
        $this->view->render('restricted/index');
    }

    public function badTokenAction() // Обрабатывает ситуацию, когда пользователь пытается использовать некорректный токен доступа, отображает специальную страницу.
    {
        $this->view->render('restricted/badToken');
    }
}
