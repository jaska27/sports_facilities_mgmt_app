<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;

/**
 * RegistrationForm is the model behind the registration form.
 */
class RegistrationForm extends ActiveRecord
{
    public $first_name;
    public $last_name;
    public $sex;
    public $email;
    public $phone;
    public $street;
    public $city;
    public $postal_code;
    public $country;

    public function rules()
    {
        return [
            [['first_name', 'last_name', 'sex', 'email', 'phone', 'street','city', 'postal_code', 'country'], 'required'],
            ['email', 'email'],
            ['sex', 'validateSex'],
        ];
    }

    public function registration()
    {
        if ($this->validate()) {
            // Good!
        } else {
            // Failure!
            // Use $model->getErrors()
        }
    }

    public function validateSex($attribute, $params)
    {
        if (!in_array($this->$attribute, ['K', 'M'])) {
            $this->addError($attribute, 'Nieprawidłowa płeć.');
        }
    }
}