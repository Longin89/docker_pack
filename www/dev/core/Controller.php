<?php

namespace Core;

use Core\Application;

class Controller extends Application
{
    protected $_controller, $_action;
    public $view, $request;

    public function __construct($controller, $action) // Инициализирует контроллер, устанавливает имя и действие, создает объекты для работы с Input и View.
    {
        parent::__construct();
        $this->_controller = $controller;
        $this->_action = $action;
        $this->request = new Input();
        $this->view = new View();
    }

    protected function load_model($model) // Загружает модель из App\Models, использует имя для создания соответствующей модели и сохраняет ее в свойстве контроллера.
    {
        $modelPath = 'App\Models\\' . $model;
        $modelName = $model . 'Model';
        if (class_exists($modelPath)) {
            $this->{$model . 'Model'} = new $modelPath();
        }
    }

    public function jsonResponse($resp) // Отвечает за отправку JSON, устанавливает заголовки CORS, указывает тип содержимого и код состояния HTTP, сериализует данные в JSON.
    {
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json; charset=UTF-8');
        http_response_code(200);
        echo json_encode($resp);
        exit;
    }
}
