<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "categories".
 *
 * @property integer $category_id
 * @property string $name
 * @property string $active
 * @property string $description
 * @property string $create_date
 * @property string $last_update
 *
 * @property Events[] $events
 */
class Categories extends \yii\db\ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'active'], 'required'],
            [['create_date', 'last_update'], 'safe'],
            [['description'], 'string', 'max' => 255],
            [['active'], 'string', 'max' => 1],
            [['name'], 'unique',],
            [['name'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'category_id' => 'ID kategorii',
            'name' => 'Nazwa kategorii',
            'active' => 'Status',
            'description' => 'Opis',
            'create_date' => 'Data utworzenia',
            'last_update' => 'Data ostatniej aktualizacji',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvents()
    {
        return $this->hasMany(Events::className(), ['category_id' => 'category_id']);
    }
}
