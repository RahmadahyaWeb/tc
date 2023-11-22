<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MsConfig;

/**
 * MsConfigSearch represents the model behind the search form of `app\models\MsConfig`.
 */
class MsConfigSearch extends MsConfig
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'value', 'value2', 'input_by', 'input_date', 'modi_by', 'modi_date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = MsConfig::find();

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
            'input_date' => $this->input_date,
            'modi_date' => $this->modi_date,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'value', $this->value])
            ->andFilterWhere(['like', 'value2', $this->value2])
            ->andFilterWhere(['like', 'input_by', $this->input_by])
            ->andFilterWhere(['like', 'modi_by', $this->modi_by]);

        return $dataProvider;
    }
}
