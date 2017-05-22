<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "customers".
 *
 * @property integer $customer_id
 * @property string $first_name
 * @property string $last_name
 * @property string $pesel
 * @property string $sex
 * @property string $email
 * @property string $phone
 * @property string $street
 * @property string $city
 * @property string $postal_code
 * @property string $active
 * @property string $create_date
 * @property string $last_update
 */
class Customers extends \yii\db\ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'sex', 'pesel', 'email', 'phone', 'street', 'city', 'postal_code', 'active'], 'required'],
            [['create_date', 'last_update'], 'safe'],
            [['pesel'], 'string', 'max' => 11],
            [['pesel'], 'match', 'pattern' => '/[0-9]{11}$/', 'message' => 'Pesel musi zawierać tylko cyfry.'],
            [['pesel'], 'unique', 'message' => 'Istnieje już klient o takim numerze pesel.'],
            [['first_name'], 'string', 'max' => 30],
            [['city'], 'string', 'max' => 40],
            [['last_name', 'email', 'street'], 'string', 'max' => 50],
            [['sex', 'active'], 'string', 'max' => 1],
            [['phone'], 'match', 'pattern' => '/^[0-9]{9}$/', 'message' => 'Telefon musi zawierać tylko cyfry.'],
            [['phone'], 'string', 'max' => 9],
            [['postal_code'], 'number', 'numberPattern' => '/[0-9]{2}-[0-9]{3}$/',
                'message' => 'Kod pocztowy musi zawierać cyfry zapisane w formacie XX-XXX.'],
            [['email'], 'email', 'message' => 'Wpisany e-mail jest nieprawidłowy.'],
            [['email'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'customer_id' => 'ID klienta',
            'pesel' => 'Pesel',
            'first_name' => 'Imię',
            'last_name' => 'Nazwisko',
            'sex' => 'Płeć',
            'email' => 'E-mail',
            'phone' => 'Telefon',
            'street' => 'Ulica i numer',
            'city' => 'Miasto',
            'postal_code' => 'Kod pocztowy',
            'active' => 'Status',
            'create_date' => 'Data rejestracji',
            'last_update' => 'Data ostatniej aktualizacji',
        ];
    }

    public function getEvents()
    {
        return $this->hasMany(CustomersEvents::className(), ['customer_id' => 'customer_id']);
    }
}