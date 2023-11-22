<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TrPlafon;
use Yii;

/**
 * TrPlafonSearch represents the model behind the search form of `app\models\TrPlafon`.
 */
class TrPlafonSearch extends TrPlafon
{
    /**
     * {@inheritdoc}
     */
	 
	
    public function rules()
    {
		return [
			[['id', 'id_provider', 'biaya'], 'integer'],
			[['tanggal','id_peserta','kode_anggota','nama_peserta','nama_provider','nama_plafon','keterangan'], 'safe'],
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
        $query = TrPlafon::find();
		$query->joinWith(['peserta']);
		$query->joinWith(['provider']);
		
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
            'id_provider' => $this->id_provider,
            'biaya' => $this->biaya,
            'input_date' => $this->input_date,
            'modi_date' => $this->modi_date,
			'nama_plafon' => $this->nama_plafon
        ]);
		
		$query->andFilterWhere(['like', 'ms_peserta.kode_anggota', $this->kode_anggota]);
		$query->andFilterWhere(['like', 'ms_peserta.nama_peserta', $this->nama_peserta]);
		$query->andFilterWhere(['like', 'ms_provider.nama', $this->nama_provider]);
		//$query->andFilterWhere("nama_plafon ='".  $this->nama_plafon."'");
		$query->andFilterWhere(['like', 'tanggal', $this->tanggal]);
		$query->orderBy('tanggal DESC');
		//var_dump($dataProvider);
        return $dataProvider;
    }
}
