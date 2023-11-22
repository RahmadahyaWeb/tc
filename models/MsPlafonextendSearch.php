<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MsPlafonextend;

/**
 * MsPlafonextendSearch represents the model behind the search form of `app\models\MsPlafonextend`.
 */
class MsPlafonextendSearch extends MsPlafonextend
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'jumlah_anggota', 'nominal'], 'integer'],
            [['nama_plafon', 'level', 'input_by', 'input_date', 'modi_by', 'modi_date'], 'safe'],
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
        $query = MsPlafonextend::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => [
				'pageSize' => 10,
			],
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
            'jumlah_anggota' => $this->jumlah_anggota,
            'nominal' => $this->nominal,
            'input_date' => $this->input_date,
            'modi_date' => $this->modi_date,
        ]);

        $query->andFilterWhere(['like', 'nama_plafon', $this->nama_plafon])
            ->andFilterWhere(['like', 'level', $this->level])
            ->andFilterWhere(['like', 'input_by', $this->input_by])
            ->andFilterWhere(['like', 'modi_by', $this->modi_by]);

        return $dataProvider;
    }
}
