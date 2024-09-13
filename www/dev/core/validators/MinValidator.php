<?php

namespace Core\Validators;

use Core\Validators\CustomValidator;

class MinValidator extends CustomValidator
{
  public function runValidation() // Проверяет валидацию на минимально допустимое значение.
  {
    $value = $this->_model->{$this->field};
    $pass = (strlen($value) >= $this->rule);
    return $pass;
  }
}
