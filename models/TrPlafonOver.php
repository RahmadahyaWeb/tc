<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tr_plafon_over".
 *
 * @property int $id
 * @property int $id_peserta
 * @property int $id_provider
 * @property int $id_tr_plafon
 * @property string $nama_plafon
 * @property string $tanggal
 * @property string $tanggal_selesai
 * @property int $biaya
 * @property string|null $status
 *
 * @property MsPeserta $peserta
 * @property MsProvider $provider
 * @property TrPlafon $trPlafon
 */
class TrPlafonOver extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tr_plafon_over';
    }

    /**
     * {@inheritdoc}
     */
    // public function rules()
    // {
    //     return [
    //         [['id_peserta', 'id_provider', 'id_tr_plafon', 'nama_plafon', 'tanggal', 'tanggal_selesai', 'biaya'], 'required'],
    //         [['id_peserta', 'id_provider', 'id_tr_plafon', 'biaya'], 'integer'],
    //         [['tanggal', 'tanggal_selesai'], 'safe'],
    //         [['nama_plafon'], 'string', 'max' => 200],
    //         [['status'], 'string', 'max' => 20],
    //         [['id_peserta'], 'exist', 'skipOnError' => true, 'targetClass' => MsPeserta::className(), 'targetAttribute' => ['id_peserta' => 'id']],
    //         [['id_provider'], 'exist', 'skipOnError' => true, 'targetClass' => MsProvider::className(), 'targetAttribute' => ['id_provider' => 'id']],
    //         [['id_tr_plafon'], 'exist', 'skipOnError' => true, 'targetClass' => TrPlafon::className(), 'targetAttribute' => ['id_tr_plafon' => 'id']],
    //     ];
    // }

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
            'nama_plafon' => 'Nama Plafon',
            'tanggal' => 'Tanggal',
            'tanggal_selesai' => 'Tanggal Selesai',
            'biaya' => 'Biaya',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[Peserta]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPeserta()
    {
        return $this->hasOne(MsPeserta::className(), ['id' => 'id_peserta']);
    }

    /**
     * Gets query for [[Provider]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProvider()
    {
        return $this->hasOne(MsProvider::className(), ['id' => 'id_provider']);
    }

    /**
     * Gets query for [[TrPlafon]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTrPlafon()
    {
        return $this->hasOne(TrPlafon::className(), ['id' => 'id_tr_plafon']);
    }
}
