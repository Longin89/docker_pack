<?php

namespace Core\Validators;

use \Exception;

abstract class CustomValidator
{
    public $success = true, $msg = '', $field, $rule;
    protected $_model;

    public function __construct($model, $params) // Инициализирует объект валидатора.
    {
        $this->_model = $model;
        if (!array_key_exists('field', $params)) {
            throw new Exception('You must add field to the params');
        } else {
            $this->field = (is_array($params['field'])) ? $params['field'][0] : $params['field'];
        }
        if (!property_exists($model, $this->field)) {
            throw new Exception('The field must exists in the model');
        }
        if (!array_key_exists('msg', $params)) {
            throw new Exception('You must add a msg to the params');
        } else {
            $this->msg = $params['msg'];
        }
        if (array_key_exists('rule', $params)) {
            $this->rule = $params['rule'];
        }

        try {
            $this->success = $this->runValidation();
        } catch (Exception $e) {
            echo "Validation exception on " . get_class() . ": " . $e->getMessage();
        }
    }

    abstract public function runValidation(); // Абстрактный метод, который должен быть реализован в подклассах.
}
