<?php

namespace App\Models;

use Core\Model;
use Core\Validators\RequiredValidator;
use Core\Validators\MaxValidator;
use Core\Validators\UniqueValidator;

class Contacts extends Model
{

  public $id, $user_id, $fname, $lname, $email, $address, $city, $zipcode;
  public $phone_number, $deleted = 0;

  public function __construct() // Устанавливает имя таблицы и включает мягкое удаление. Это позволяет использовать функциональность мягкого удаления из базового класса Model.
  {
    $table = 'contacts';
    parent::__construct($table);
    $this->_softDelete = true;
  }

  public function validator() // Определяет правила валидации для различных полей модели, использует валидаторы из пространства имен Core\Validators.
  {
    $this->runValidation(new RequiredValidator($this, ['field' => 'fname', 'msg' => 'First Name is required.']));
    $this->runValidation(new MaxValidator($this, ['field' => 'fname', 'msg' => 'First Name must be less than 155 characters.', 'rule' => 155]));
    $this->runValidation(new RequiredValidator($this, ['field' => 'lname', 'msg' => 'Last Name is required.']));
    $this->runValidation(new MaxValidator($this, ['field' => 'lname', 'msg' => 'Last Name must be less than 155 characters.', 'rule' => 155]));
    $this->runValidation(new UniqueValidator($this, ['field' => 'email', 'msg' => 'This email already exist']));
    $this->runValidation(new UniqueValidator($this, ['field' => 'phone_number', 'msg' => 'This phone number already exist']));
  }

  public function findAllByUserId($user_id, $params = []) // Находит все контакты для конкретного пользователя с возможностью добавления дополнительных параметров запроса.
  {
    $conditions = [
      'conditions' => 'user_id = ?',
      'bind' => [$user_id]
    ];
    $conditions = array_merge($conditions, $params);
    return $this->find($conditions);
  }

  public function displayName()
  {
    return $this->fname . ' ' . $this->lname;
  }

  public function findByIdAndUserId($contact_id, $user_id, $params = [])
  {
    $conditions = [
      'conditions' => 'id = ? AND user_id = ?',
      'bind' => [$contact_id, $user_id]
    ];
    $conditions = array_merge($conditions, $params);
    return $this->findFirst($conditions);
  }

  public function displayAddress() // Форматирует адрес контакта для отображения.
  {
    $address = '';
    if (!empty($this->address)) {
      $address .= $this->address . '<br>';
    }

    if (!empty($this->city)) {
      $address .= $this->city . ', ';
    }
    $address .= ' ' . $this->zipcode . '<br>';
    return $address;
  }

  public function displayAddressLabel() // Создает HTML-метку с именем и адресом контакта.
  {
    $html = $this->displayName() . '<br />';
    $html .= $this->displayAddress();
    return $html;
  }
}
