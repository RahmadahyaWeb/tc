<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TrPlafon;
use Yii;

/**
 * TrPlafonSearch represents the model behind the search form of `app\models\TrPlafon`.
 */
class TrPlafonSearchPeserta extends TrPlafon
{
    /**
     * {@inheritdoc}
     */
	 
	
    public function rules()
    {
		return [
			[['id', 'id_provider'], 'integer'],
			[['id_peserta','nama_plafon','tanggal'], 'safe'],
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
		$this->tanggal = substr($this->tanggal,0,4);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
		if($this->tanggal != ""){
			if($this->nama_plafon == "KACAMATA"){
				$tahunlalu = $this->tanggal - 1;
				$query->Where(" left(tanggal,4) in ('".  $this->tanggal."','".$tahunlalu."')");
			} else {
				$query->Where(" left(tanggal,4) = '".  $this->tanggal."'");
			}
			
		}
		// grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_provider' => $this->id_provider,
            'biaya' => $this->biaya,
            'input_date' => $this->input_date,
            'modi_date' => $this->modi_date,
			'nama_plafon' => $this->nama_plafon,
			//'tanggal'=> $this->tanggal,
        ]);
		
		$query->andFilterWhere(['like', 'ms_peserta.kode_anggota', $this->kode_anggota]);
		$query->andFilterWhere(['like', 'ms_peserta.nama_peserta', $this->nama_peserta]);
        $query->andFilterWhere(['like', 'ms_provider.nama', $this->nama_provider]);
        $query->andWhere(['nonbenefit' => null]);
		
		//$query->andFilterWhere(['like', 'tanggal', substr($this->tanggal,0,4)]);
        $query->orderBy('tanggal DESC');
        
        // var_dump($query); exit;
		//var_dump($dataProvider);
        return $dataProvider;
    }
}
