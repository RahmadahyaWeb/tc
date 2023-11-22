<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tr_progress".
 *
 * @property string $resi
 * @property int $id_peserta
 * @property string $tanggal
 * @property int $biaya
 * @property string $status
 * @property string $status_date
 * @property int $progress
 * @property string|null $progress_1
 * @property string|null $progress_2
 * @property string|null $progress_3
 * @property string|null $progress_4
 * @property int|null $id_trans
 * @property string|null $input_by
 * @property string|null $input_date
 * @property string|null $modif_by
 * @property string|null $modif_date
 *
 * @property MsProgress $progress0
 * @property MsPeserta $peserta
 */
class TrProgress extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tr_progress';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['resi', 'id_peserta', 'tanggal', 'biaya', 'status', 'progress'], 'required'],
            [['id_peserta', 'biaya', 'progress', 'id_trans'], 'integer'],
            [['tanggal', 'status_date', 'progress_1', 'progress_2', 'progress_3', 'progress_4', 'input_date', 'modif_date','ket_app'], 'safe'],
            [['resi'], 'string', 'max' => 50],
            [['status'], 'string', 'max' => 10],
            [['input_by', 'modif_by'], 'string', 'max' => 30],
            [['resi'], 'unique'],
            [['progress'], 'exist', 'skipOnError' => true, 'targetClass' => MsProgress::className(), 'targetAttribute' => ['progress' => 'progress']],
            [['id_peserta'], 'exist', 'skipOnError' => true, 'targetClass' => MsPeserta::className(), 'targetAttribute' => ['id_peserta' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'resi' => 'Resi',
            'id_peserta' => 'Id Peserta',
            'tanggal' => 'Tanggal Kwitansi',
            'biaya' => 'Biaya',
            'status' => 'Status Approval',
            'status_date' => 'Tanggal Approval',
            'progress' => 'Progress',
            'progress_1' => 'Tgl. Terima',
            'progress_2' => 'Tgl. Verval',
            'progress_3' => 'Tgl. Proses Finance',
            'progress_4' => 'Tgl. Pencairan',
            'id_trans' => 'Id Trans',
            'input_by' => 'Input By',
            'input_date' => 'Input Date',
            'modif_by' => 'Modif By',
            'modif_date' => 'Modif Date',
            'ket_app' => 'Keterangan Approval'
        ];
    }

    /**
     * Gets query for [[Progress0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProgress0()
    {
        return $this->hasOne(MsProgress::className(), ['progress' => 'progress']);
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
}
