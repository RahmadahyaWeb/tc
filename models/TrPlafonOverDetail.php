<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tr_plafon_over_detail".
 *
 * @property int $id
 * @property int $id_peserta
 * @property int $id_provider
 * @property int $id_tr_plafon
 * @property string $tanggal
 * @property string $tanggal_selesai
 * @property int $biaya
 * @property string|null $status
 */
class TrPlafonOverDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tr_plafon_over_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_peserta', 'id_provider', 'id_tr_plafon', 'tanggal', 'tanggal_selesai', 'biaya'], 'required'],
            [['id_peserta', 'id_provider', 'id_tr_plafon', 'biaya'], 'integer'],
            [['tanggal', 'tanggal_selesai'], 'safe'],
            [['status'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_peserta' => 'Id Peserta',
            'id_provider' => 'Id Provider',
            'id_tr_plafon' => 'Id Tr Plafon',
            'tanggal' => 'Tanggal',
            'tanggal_selesai' => 'Tanggal Selesai',
            'biaya' => 'Biaya',
            'status' => 'Status',
        ];
    }
}
