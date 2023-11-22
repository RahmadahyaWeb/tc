<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TrProgressProvider;

/**
 * TrProgressProviderSearch represents the model behind the search form of `app\models\TrProgressProvider`.
 */
class TrProgressProviderSearch extends TrProgressProvider
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['resi', 'no_invoice', 'tanggal_pembuatan_invoice', 'tanggal_penerimaan_invoice', 'tanggal_verifikasi_validasi_invoice', 'tanggal_pembayaran_invoice', 'bukti_pembayaran'], 'safe'],
            [['id_provider', 'nominal_tagihan'], 'integer'],
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
        $query = TrProgressProvider::find();

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
            'id_provider' => $this->id_provider,
            'nominal_tagihan' => $this->nominal_tagihan,
            'tanggal_pembuatan_invoice' => $this->tanggal_pembuatan_invoice,
            'tanggal_penerimaan_invoice' => $this->tanggal_penerimaan_invoice,
            'tanggal_verifikasi_validasi_invoice' => $this->tanggal_verifikasi_validasi_invoice,
            'tanggal_pembayaran_invoice' => $this->tanggal_pembayaran_invoice,
        ]);

        $query->andFilterWhere(['like', 'resi', $this->resi])
            ->andFilterWhere(['like', 'no_invoice', $this->no_invoice])
            ->andFilterWhere(['like', 'bukti_pembayaran', $this->bukti_pembayaran]);

        return $dataProvider;
    }
}