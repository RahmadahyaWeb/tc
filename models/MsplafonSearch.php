<?php

namespace app\models;

use Yii;
use yii\base\Model;
//use app\models\MsJenisPlafon;
use yii\data\ActiveDataProvider;

class MsplafonSearch extends MsPlafon
{
    public function rules()
    { 
        // only fields in rules() are searchable
        return [
            [['level','nama_plafon'], 'string'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }
	
	
    public function search($params)
    {
		
		$query = MsPlafon::find();
		$dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => [
				'pageSize' => 6,
			],
        ]);

        if (!($this->load($params) && $this->validate())) {
			return $dataProvider;
        }

        // adjust the query by adding the filters
		$query->Where(['like', 'nama_plafon', $this->nama_plafon]);
		
        $query->andFilterWhere(['like', 'level', $this->level]);
		return $dataProvider;
    }
}