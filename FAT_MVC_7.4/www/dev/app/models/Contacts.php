<?php

namespace App\Models;

use Core\Model;
use Core\Validators\RequiredValidator;
use Core\Validators\MaxValidator;

class Contacts extends Model
{
    public $id, $user_id, $fname, $lname, $email, $address, $city, $zipcode;
    public $phone_number, $deleted = 0;

    public function __construct()
    {
        $table = 'contacts';
        parent::__construct($table);
        $this->_softDelete = true;
    }

    public function validator()
    {
        $this->runValidation(new RequiredValidator($this, ['field' => 'fname', 'msg' => 'First Name is required']));
        $this->runValidation(new RequiredValidator($this, ['field' => 'lname', 'msg' => 'Last Name is required']));
        $this->runValidation(new MaxValidator($this, ['field' => 'fname', 'msg' => 'First name must be max 155 chars', 'rule' => 155]));
        $this->runValidation(new MaxValidator($this, ['field' => 'lname', 'msg' => 'Last name must be max 155 chars', 'rule' => 155]));
    }

    public function findAllByUserId($user_id, $params = [])
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

    public function displayAddress()
    {
        $address = '';
        if (!empty($address)) {
            $address .= $this->address . '<br>';
        }
        if (!empty($this->city)) {
            $address .= $this->city . ', ';
        }
        return $address;
    }

    public function displayAddressLabel()
    {
        $html = $this->displayName() . '<br />';;
        $html .= $this->displayAddress();
        return $html;
    }
}
