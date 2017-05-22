<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Instructors;

/**
 * InstructorsSearch represents the model behind the search form about `app\models\Instructors`.
 */
class InstructorsSearch extends Instructors
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['instructor_id'], 'integer'],
            [['first_name', 'last_name', 'pesel','sex', 'email', 'phone', 'street', 'city', 'postal_code', 'id_card', 'active', 'description', 'create_date', 'last_update'], 'safe'],
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
        $query = Instructors::find();

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

        // grid filtering conditions
        $query->andFilterWhere([
            'instructor_id' => $this->instructor_id,
            'create_date' => $this->create_date,
            'last_update' => $this->last_update,
        ]);

        $query->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'pesel', $this->pesel])
            ->andFilterWhere(['like', 'sex', $this->sex])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'street', $this->street])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'postal_code', $this->postal_code])
            ->andFilterWhere(['like', 'id_card', $this->id_card])
            ->andFilterWhere(['like', 'active', $this->active])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
