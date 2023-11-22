<?php

namespace app;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MsProgress;

/**
 * modelsMsProgressSearch represents the model behind the search form of `app\models\MsProgress`.
 */
class modelsMsProgressSearch extends MsProgress
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['progress'], 'integer'],
            [['status'], 'safe'],
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
        $query = MsProgress::find();

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
            'progress' => $this->progress,
        ]);

        $query->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
