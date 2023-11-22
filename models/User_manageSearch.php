<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User_manage;
use Yii;

/**
 * TrPlafonSearch represents the model behind the search form of `app\models\TrPlafon`.
 */
class User_manageSearch extends User_manage
{
    /**
     * {@inheritdoc}
     */
	 
	
    public function rules()
    {
		return [
			 [['username', 'password', 'user_group','last_login','active'], 'safe'],
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
        $query = User_manage::find();
		
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        
		$query->andFilterWhere(['like', 'username', $this->username]);
		$query->andFilterWhere(['like', 'password', $this->password]);
		$query->andFilterWhere(['like', 'user_group', $this->user_group]);
		$query->andFilterWhere(['like', 'last_login', $this->last_login]);
		$query->andFilterWhere(['like', 'active', $this->active]);
		
        return $dataProvider;
    }
}
