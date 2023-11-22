<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tr_plafon".
 *
 * @property int $id
 * @property int $id_peserta
 * @property int $id_provider
 * @property string $tanggal
 * @property int $biaya
 * @property string $input_by
 * @property string $input_date
 * @property string|null $modi_by
 * @property string|null $modi_date
 *
 * @property MsPeserta $peserta
 * @property MsProvider $provider
 */
class TrPlafon extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tr_plafon';
    }

    public $kode_anggota;
    public $nama_peserta;
    public $nama_provider;
    public $keterangan;

    //public $kode_anggota;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_peserta', 'id_provider', 'tanggal', 'biaya'], 'required'],
            [['id_peserta', 'id_provider', 'biaya'], 'integer'],
            [['tanggal', 'tanggal_selesai', 'kode_anggota', 'nama_peserta', 'nama_provider', 'nama_plafon'], 'safe'],
            [['id_peserta'], 'exist', 'skipOnError' => true, 'targetClass' => MsPeserta::className(), 'targetAttribute' => ['id_peserta' => 'id']],
            [['id_provider'], 'exist', 'skipOnError' => true, 'targetClass' => MsProvider::className(), 'targetAttribute' => ['id_provider' => 'id']],
            [['nama_plafon'], 'exist', 'skipOnError' => true, 'targetClass' => MsJenisPlafon::className(), 'targetAttribute' => ['nama_plafon' => 'nama_plafon']],
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
            'tanggal' => 'Tanggal Mulai',
            'tanggal_selesai' => 'Tanggal Selesai',
            'biaya' => 'Biaya',
            'input_by' => 'Input By',
            'input_date' => 'Input Date',
            'modi_by' => 'Modi By',
            'modi_date' => 'Modi Date',
            'kode_anggota' =>  'Kode Anggota',
            'nama_peserta' =>  'Nama Peserta',
            'nama_provider' =>  'Nama Provider',
            'nama_plafon' => 'Nama Plafon',
        ];
    }

    /**
     * Gets query for [[Peserta]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getPeserta()
    {
        return $this->hasOne(MsPeserta::className(), ['id' => 'id_peserta']);
    }

    public function getProvider()
    {
        return $this->hasOne(MsProvider::className(), ['id' => 'id_provider']);
    }

     public function getProgress()
    {
        return $this->hasOne(TrProgress::className(), ['id_peserta' => 'id_peserta']);
    }

    public function getJenisplafon()
    {
        return $this->hasOne(MsJenisPlafon::className(), ['nama_plafon' => 'nama_plafon']);
    }

    /**
     * {@inheritdoc}
     * @return TrPlafonQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TrPlafonQuery(get_called_class());
    }

    public function getAllTransPertahun($kode_anggota, $nama_plafon, $tahun)
    {
        $modelPeserta = new MsPeserta();
        $id = "";
        //$induk = $modelPeserta->getPesertaIndukAll($kode_anggota);
        // $anggota = $modelPeserta->getPesertaAnggota($kode_anggota);
        $all = $modelPeserta->getPesertaAll($kode_anggota);
        if($nama_plafon == 'RAWAT INAP'){
            foreach($all as $da){
                $id .= "'".$da->id."',";
            }
        }
        $id = substr($id, 0, -1);
        $dataTr = self::find()
            ->where("id_peserta in (" . $id . ")")
            ->andWhere("nama_plafon='" . $nama_plafon . "'")
            ->andWhere("left(tanggal,4) = '" . $tahun . "'")
            ->all();
        return $dataTr;
    }

    // public function getTransPersalinan($id)
    // {
    //     $dataTr = self::find()
    //         ->where("id_peserta = ".$id)
    //         ->andWhere("nama_plafon in (
    //             'PERSALINAN DENGAN BANTUAN BIDAN',
    //             'PERSALINAN DENGAN BANTUAN DOKTER (NORMAL)',
    //             'PERSALINAN DENGAN BANTUAN DOKTER (CAESAR)',
    //             'PERSALINAN DILUAR RAHIM (KEHAMILAN EKTOPIK)',
    //             'VAKUM ASPIRASI/KURET',
    //         )")
    //         ->all();
    //     return $dataTr;
    // }
}
