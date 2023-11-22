<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class MspesertaSearch extends MsPeserta
{
    public function rules()
    { 
        // only fields in rules() are searchable
        return [
            [['kode_anggota', 'nama_peserta','keterangan','jenis_kelamin','tempat_lahir','tgl_lahir','level_jabatan'], 'string'],
			[['tgl_lahir'],'safe']
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = MsPeserta::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        // adjust the query by adding the filters
        $query->andFilterWhere(['like', 'kode_anggota', $this->kode_anggota]);
        $query->andFilterWhere(['like', 'nama_peserta', $this->nama_peserta])
              ->andFilterWhere(['like', 'keterangan', $this->keterangan])
			  ->andFilterWhere(['like', 'jenis_kelamin', $this->jenis_kelamin])
			  ->andFilterWhere(['like', 'tempat_lahir', $this->tempat_lahir])
			  ->andFilterWhere(['like', 'tgl_lahir', $this->tgl_lahir])
			  ->andFilterWhere(['like', 'level_jabatan', $this->level_jabatan]);

        return $dataProvider;
    }
}