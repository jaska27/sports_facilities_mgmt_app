<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property string $user_id
 * @property string $pesel
 * @property string $first_name
 * @property string $last_name
 * @property string $sex
 * @property string $email
 * @property integer $phone
 * @property string $username
 * @property string $password
 * @property string $active
 * @property string $create_date
 * @property string $last_update
 */
class Users extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'pesel', 'first_name', 'last_name', 'sex', 'email', 'phone', 'username', 'password'], 'required'],
            [['phone'], 'match', 'pattern' => '/^[0-9]{9}$/', 'message' => 'Telefon musi zawierać tylko cyfry.'],
            [['phone'], 'string', 'max' => 9],
            [['create_date', 'last_update'], 'safe'],
            [['first_name'], 'string', 'max' => 30],
            [['last_name', 'email'], 'string', 'max' => 50],
            [['sex', 'active'], 'string', 'max' => 1],
            [['password'], 'string', 'max' => 20],
            [['username'], 'string', 'max' => 60],
            [['username'], 'unique'],
            [['pesel'], 'string', 'max' => 11],
            [['pesel'], 'match', 'pattern' => '/[0-9]{11}$/', 'message' => 'Pesel musi zawierać tylko cyfry.'],
            [['pesel'], 'unique', 'message' => 'Istnieje już użytkownik o takim numerze pesel.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'ID użytkownika',
            'pesel' => 'Pesel',
            'first_name' => 'Imię',
            'last_name' => 'Nazwisko',
            'sex' => 'Płeć',
            'email' => 'E-mail',
            'phone' => 'Telefon',
            'login' => 'Login',
            'password' => 'Hasło',
            'auth_key' => 'Auth Key',
            'active' => 'Status',
            'create_date' => 'Data rejestracji',
            'last_update' => 'Data ostatniej aktualizacji',
        ];
    }

    /**
     * Finds an identity by the given ID.
     * @param string|integer $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException();
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|integer an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        return $this->user_id;
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        //return $this->auth_key;
        throw new NotSupportedException();
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return boolean whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        //return $this->auth_key === $authKey;
        throw new NotSupportedException();
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return self::findOne(['username' => $username]);
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }
}
