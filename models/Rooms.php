<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rooms".
 *
 * @property integer $room_id
 * @property string $name
 * @property Schedule[] $schedules
 */
class Rooms extends \yii\db\ActiveRecord
{
    const ROOM_1 = 1;
    const ROOM_2 = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rooms';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 25],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'room_id' => 'ID pomieszczenia',
            'name' => 'Nazwa pomieszczenia',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSchedules()
    {
        return $this->hasMany(Schedule::className(), ['room' => 'room_id']);
    }
}
