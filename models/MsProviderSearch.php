<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MsProvider;

/**
 * MsProviderSearch represents the model behind the search form of `app\models\MsProvider`.
 */
class MsProviderSearch extends MsProvider
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['jenis_provider', 'nama', 'kab_kota', 'alamat', 'no_telp', 'web'], 'safe'],
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
        $query = MsProvider::find();

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
            'id' => $this->id,
            'input_date' => $this->input_date,
            'modi_date' => $this->modi_date,
        ]);

        $query->andFilterWhere(['like', 'jenis_provider', $this->jenis_provider])
            ->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'kab_kota', $this->kab_kota])
            ->andFilterWhere(['like', 'alamat', $this->alamat])
            ->andFilterWhere(['like', 'no_telp', $this->no_telp])
            ->andFilterWhere(['like', 'web', $this->web])
            ->andFilterWhere(['like', 'input_by', $this->input_by])
            ->andFilterWhere(['like', 'modi_by', $this->modi_by]);

        return $dataProvider;
    }
}
