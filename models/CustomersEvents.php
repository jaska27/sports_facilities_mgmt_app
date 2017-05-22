<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "customers_events".
 *
 * @property integer $event_id
 * @property integer $customer_id
 * @property string $create_date
 * @property Events $event
 * @property Customers $customer
 */
class CustomersEvents extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customers_events';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['event_id', 'customer_id'], 'required'],
            [['event_id', 'customer_id'], 'integer'],
            [['create_date'], 'safe'],
            [['event_id'], 'exist', 'skipOnError' => true, 'targetClass' => Events::className(), 'targetAttribute' => ['event_id' => 'event_id']],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customers::className(), 'targetAttribute' => ['customer_id' => 'customer_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'event_id' => 'ID kursu',
            'customer_id' => 'ID klienta',
            'create_date' => 'Data zapisu',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvent()
    {
        return $this->hasOne(Events::className(), ['event_id' => 'event_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customers::className(), ['customer_id' => 'customer_id']);
    }
}
