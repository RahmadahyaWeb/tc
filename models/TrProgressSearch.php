<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TrProgress;
/**
 * TrProgressSearch represents the model behind the search form of `app\models\TrProgress`.
 */
class TrProgressSearch extends TrProgress
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['resi', 'tanggal', 'status', 'status_date', 'progress_1', 'progress_2', 'progress_3', 'progress_4', 'input_by', 'input_date', 'modif_by', 'modif_date'], 'safe'],
            [['id_peserta', 'biaya', 'progress', 'id_trans'], 'integer'],
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
    public function search($params, $in = null)
    {
        $query = TrProgress::find();

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
        if($in != null){
            $query->where("id_peserta in  (".$in.")");
        }
        // grid filtering conditions
        $query->andFilterWhere([
            'id_peserta' => $this->id_peserta,
            'tanggal' => $this->tanggal,
            'biaya' => $this->biaya,
            'status_date' => $this->status_date,
            'progress' => $this->progress,
            'progress_1' => $this->progress_1,
            'progress_2' => $this->progress_2,
            'progress_3' => $this->progress_3,
            'progress_4' => $this->progress_4,
            'id_trans' => $this->id_trans,
            'input_date' => $this->input_date,
            'modif_date' => $this->modif_date,
        ]);

        $query->andFilterWhere(['like', 'resi', $this->resi])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'input_by', $this->input_by])
            ->andFilterWhere(['like', 'modif_by', $this->modif_by]);
        return $dataProvider;
    }
}
