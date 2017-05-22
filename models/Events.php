<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "events".
 *
 * @property integer $event_id
 * @property string $name
 * @property string $description
 * @property integer $instructor_id
 * @property integer $category_id
 * @property integer $duration
 * @property string $active
 * @property string $create_date
 * @property string $last_update
 * @property Instructors $instructor
 * @property Categories $category
 * @property Schedule[] $schedules
 */
class Events extends \yii\db\ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'events';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'instructor_id', 'category_id', 'active'], 'required'],
            [['instructor_id', 'category_id'], 'integer'],
            [['create_date', 'last_update'], 'safe'],
            [['description'], 'string', 'max' => 255],
            [['name'], 'string', 'max' => 30],
            [['name'], 'unique'],
            [['active'], 'string', 'max' => 1],
            [['instructor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Instructors::className(), 'targetAttribute' => ['instructor_id' => 'instructor_id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['category_id' => 'category_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'event_id' => 'ID kursu',
            'name' => 'Nazwa kursu',
            'description' => 'Opis',
            'instructor_id' => 'Instruktor',
            'category_id' => 'Kategoria',
            'active' => 'Status',
            'create_date' => 'Data utworzenia',
            'last_update' => 'Data ostatniej aktualizacji',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstructor()
    {
        return $this->hasOne(Instructors::className(), ['instructor_id' => 'instructor_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Categories::className(), ['category_id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSchedules()
    {
        return $this->hasMany(Schedule::className(), ['event_id' => 'event_id']);
    }

    public function getCustomers()
    {
        return $this->hasMany(CustomersEvents::className(), ['event_id' => 'event_id']);
    }
}
