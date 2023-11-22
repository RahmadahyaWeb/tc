<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

class TrSurat extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'tr_surat';
    }

    // public $kode_anggota;
    // public $nama_peserta;
    // public $nama_provider;
    // public $keterangan;

    //public $kode_anggota;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['no_surat', 'jenis_surat', 'tgl_surat', 'id_peserta', 'informasi_sakit'], 'required'],
            [['tgl_kuitansi', 'tgl_terimaclaim', 'tgl_exp1', 'tgl_exp2', 'tujuan_surat', 'up_surat', 'nama_pengurus', 'jabatan', 'alamat', 'nama_peserta', 'alamat_peserta', 'kode_anggota', 'keterangan_reject', 'nominal_reject'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'no_surat' => 'No. Surat',
            'jenis_surat' => 'Jenis Surat',
            'tgl_surat' => 'Tgl. Surat',
            'tgl_kuitansi' => 'Tgl. Kuitansi',
            'tgl_terimaclaim' => 'Tgl, Terima Claim',
            'tgl_exp1' => 'Tgl. Terbit',
            'tgl_exp2' => 'Tgl. Kedaluarsa',
            'tujuan_surat' => 'Tujuan',
            'up_surat' => 'UP',
            'nama_pengurus' => 'Nama Pengurus',
            'jabatan' => 'Jabatan Pengurus',
            'alamat' => 'Alamat Pengurus',
            'nama_peserta' => 'Nama Peserta',
            'alamat_peserta' =>  'Alamat Peserta',
            'kode_anggota' =>  'Kode Anggota',
            'informasi_sakit' =>  'Informasi/Keterangan',
            'keterangan_reject' => 'Keterangan Reject',
            'nominal_reject' => 'Nominal Reject',
            'input_by'=> 'Dibuat Oleh',
            'input_date'=> 'Dibuat Pada',
            'modi_by'=> 'Diperbarui Oleh',
            'modi_date'=> 'Diperbarui Pada',
        ];
    }

    public static function find()
    {
        return new TrPlafonQuery(get_called_class());
    }

    public function listJenisSurat()
    {
        $list = [
            1 => [
                'code' => 'Surat Jaminan Rawat Inap'
            ],
            2 => [
                'code' => 'Surat Jaminan Melahirkan'
            ],
            3 => [
                'code' => 'Surat Jaminan Kecelakaan'
            ],
            4 => [
                'code' => 'Surat Pengantar Berobat'
            ],
            5 => [
                'code' => 'Surat Klaim Reject'
            ]
        ];
        return ArrayHelper::map($list, 'code', 'code');
    }

    public function getBulanRomawi($m)
    {
        $res = "";
        if ($m == '1' or $m == '01') {
            $res = "I";
        } else if ($m == '2' or $m == '02') {
            $res = "II";
        } else if ($m == '3' or $m == '03') {
            $res = "III";
        } else if ($m == '4' or $m == '04') {
            $res = "IV";
        } else if ($m == '5' or $m == '05') {
            $res = "V";
        } else if ($m == '6' or $m == '06') {
            $res = "VI";
        } else if ($m == '7' or $m == '07') {
            $res = "VII";
        } else if ($m == '8' or $m == '08') {
            $res = "VIII";
        } else if ($m == '9' or $m == '09') {
            $res = "IX";
        } else if ($m == '10' or $m == '10') {
            $res = "X";
        } else if ($m == '11' or $m == '11') {
            $res = "XI";
        } else {
            $res = "XII";
        }
        return $res;
    }
}
