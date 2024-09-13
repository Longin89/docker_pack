<?php

namespace Core\Validators;

use Core\Validators\CustomValidator;

class NumericValidator extends CustomValidator
{
    public function runValidation() // // Проверяет валидацию на цифровое значение.
    {
        $value = $this->_model->{$this->field};
        $pass = true;
        if (!empty($value)) {
            $pass = is_numeric($value);
        }
        return $pass;
    }
}
