<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * EventsSearch represents the model behind the search form about `app\models\Events`.
 */
class EventsSearch extends Events
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['event_id', 'instructor_id'], 'integer'],
            [['name', 'description', 'category_id', 'active', 'create_date', 'last_update'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Events::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->joinWith('category');

        // grid filtering conditions
        $query->andFilterWhere([
            'event_id' => $this->event_id,
            'instructor_id' => $this->instructor_id,
            'create_date' => $this->create_date,
            'last_update' => $this->last_update,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'categories.name', $this->category_id])
            ->andFilterWhere(['like', 'active', $this->active]);

        return $dataProvider;
    }
}
