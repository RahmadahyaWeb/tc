<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MsUnitBisnis;

/**
 * MsUnitBisnisSearch represents the model behind the search form of `app\models\MsUnitBisnis`.
 */
class MsUnitBisnisSearch extends MsUnitBisnis
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['unit_bisnis', 'input_by', 'input_date', 'modi_by', 'modi_date','alias'], 'safe'],
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
        $query = MsUnitBisnis::find();

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

        $query->andFilterWhere(['like', 'unit_bisnis', $this->unit_bisnis])
            ->andFilterWhere(['like', 'input_by', $this->input_by])
            ->andFilterWhere(['like', 'modi_by', $this->modi_by]);

        return $dataProvider;
    }
}
