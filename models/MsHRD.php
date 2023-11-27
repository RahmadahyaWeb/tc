<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

class MsHRD extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
	public static function getDb() {
		return Yii::$app->db_hrd;
	}
    public static function tableName()
    {
        return 'MS_KARYAWAN';
    }
	public static function primaryKey()
	{
		return ["nik"];
	}

	public $daftar;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        // return [
        //     [['kode_anggota', 'nama_peserta', 'keterangan', 'jenis_kelamin', 'tempat_lahir', 'tgl_lahir', 'level_jabatan','departemen','unit_bisnis', 'input_by', 'active'], 'required'],
        //     [['tgl_lahir'], 'safe'],
        //     [['kode_anggota', 'input_by', 'modi_by'], 'string', 'max' => 20],
        //     [['nama_peserta', 'tempat_lahir'], 'string', 'max' => 100],
        //     [['keterangan'], 'string', 'max' => 13],
        //     [['jenis_kelamin'], 'string', 'max' => 1],
        //     [['level_jabatan'], 'string', 'max' => 50],
        //     [['alamat'], 'string', 'max' => 200],
        // ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            // 'id' => 'ID',
            // 'kode_anggota' => 'Kode Anggota',
            // 'nama_peserta' => 'Nama Peserta',
            // 'keterangan' => 'Keterangan',
            // 'jenis_kelamin' => 'Jenis Kelamin',
            // 'tempat_lahir' => 'Tempat Lahir',
            // 'tgl_lahir' => 'Tgl Lahir',
            // 'level_jabatan' => 'Level Jabatan',
			// 'divisi'=>'Divisi',
            // 'input_by' => 'Input By',
            // 'input_date' => 'Input Date',
            // 'modi_by' => 'Modi By',
            // 'modi_date' => 'Modi Date',
			// 'active'=> 'Status',
			// 'departemen' => 'Departemen',
			// 'unit_bisnis' => 'Unit Bisnis',
			// 'alamat' => 'Alamat',
        ];
    }
	
	
	public function getDataPesertaFromKaryawan($nik){
		$data = self::find()
			->select('nik, nama, kd_gender, MS_KOTA.nm_kota as kota_lahir, tgl_lahir, alamat, kd_cabang, kd_divisi, kd_jabatan, kd_status_karyawan')
			->leftJoin('MS_KOTA', 'MS_KOTA.kd_kota = MS_KARYAWAN.kota_lahir')
			->where(['nik' => $nik])
			->one();
		return $data;
	}

    public function getDataKaryawanNonAktif(){
		$data = self::find()
            ->select('nik, nama, MS_CABANG.nm_cabang as kd_cabang, tgl_keluar')
            ->leftJoin('MS_CABANG', 'MS_CABANG.kd_cabang = MS_KARYAWAN.kd_cabang')
            ->where("(tgl_keluar >= DATEADD(day, 1, DATEADD(month, -3, GETDATE())) AND tgl_keluar < GETDATE()) AND kd_status_karyawan='STS-4'")
            ->orderBy('tgl_keluar')
            ->all();

        return $data;
	}

    public function getDataUser(){
        $data = self::find()
        ->select('*')
        ->all();

        return $data;
    }
}
