<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TrSurat;
use Yii;

/**
 * TrSuratSearch represents the model behind the search form of `app\models\TrSurat`.
 */
class TrSuratSearch extends TrSurat
{
    /**
     * {@inheritdoc}
     */
	 
	
    public function rules()
    {
		return [
			[['no_surat','jenis_surat','tgl_surat','tujuan_surat','up_surat','nama_pengurus','jabatan_pengurus','alamat','alamat_peserta','informasi_sakit','kode_anggota','nama_peserta'], 'safe'],
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
        $query = TrSurat::find();
		
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
            'id' => $this->id
            // 'biaya' => $this->biaya,
            // 'input_date' => $this->input_date,
            // 'modi_date' => $this->modi_date,
			// 'nama_plafon' => $this->nama_plafon
        ]);
		//$query->andFilterWhere("nama_plafon ='".  $this->nama_plafon."'");
		$query->andFilterWhere(['like', 'no_surat', $this->no_surat]);
		$query->andFilterWhere(['like', 'jenis_surat', $this->jenis_surat]);
		$query->andFilterWhere(['like', 'tgl_surat', $this->tgl_surat]);
		$query->andFilterWhere(['like', 'kode_anggota', $this->kode_anggota]);
		$query->andFilterWhere(['like', 'nama_peserta', $this->nama_peserta]);
		$query->andFilterWhere(['like', 'tujuan_surat', $this->tujuan_surat]);
		$query->andFilterWhere(['like', 'up_surat', $this->up_surat]);
		$query->orderBy('id DESC');
		//var_dump($dataProvider);
        return $dataProvider;
    }
}
