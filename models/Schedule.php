<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "schedule".
 *
 * @property integer $schedule_id
 * @property integer $event_id
 * @property string $date
 * @property string $time_start
 * @property string $time_end
 * @property string $room
 * @property string $active
 * @property Events $event
 */
class Schedule extends \yii\db\ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'schedule';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['event_id', 'date', 'time_start', 'time_end', 'room', 'active'], 'required'],
            [['event_id'], 'integer'],
            [['date', 'time_start', 'time_end'], 'safe'],
            [['event_id'], 'exist', 'skipOnError' => true, 'targetClass' => Events::className(), 'targetAttribute' => ['event_id' => 'event_id']],
            [['room'], 'exist', 'skipOnError' => true, 'targetClass' => Rooms::className(), 'targetAttribute' => ['room' => 'room_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'schedule_id' => 'ID',
            'event_id' => 'Kurs',
            'date' => 'Data',
            'time_start' => 'Godzina rozpoczęcia',
            'time_end' => 'Godzina zakończenia',
            'room' => 'Lokalizacja',
            'active' => 'Status',
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
    public function getRoom()
    {
        return $this->hasOne(Rooms::className(), ['room' => 'room_id']);
    }
}
