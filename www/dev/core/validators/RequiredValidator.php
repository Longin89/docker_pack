<?php

namespace Core\Validators;

use Core\Validators\CustomValidator;

class RequiredValidator extends CustomValidator
{
    public function runValidation() // // Проверяет валидацию на обязательные к заполнению поля.
    {
        $value = $this->_model->{$this->field};
        $passes = (!empty($value));
        return $passes;
    }
}
