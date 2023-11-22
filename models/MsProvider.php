<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ms_provider".
 *
 * @property int $id
 * @property string $jenis_provider
 * @property string $nama
 * @property string $kab_kota
 * @property string $alamat
 * @property string $no_telp
 * @property string $web
 * @property string|null $input_by
 * @property string $input_date
 * @property string|null $modi_by
 * @property string $modi_date
 *
 * @property TrPlafon[] $trPlafons
 */
class MsProvider extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ms_provider';
    }

	public $daftar;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jenis_provider', 'nama', 'kab_kota', 'alamat', 'id_provider'], 'required'],
            [['jenis_provider', 'input_by', 'modi_by'], 'string', 'max' => 20],
            [['nama', 'kab_kota', 'web'], 'string', 'max' => 60],
            [['alamat'], 'string', 'max' => 200],
            [['no_telp'], 'string', 'max' => 13],
            ['id_provider', 'unique', 'targetClass' => MsProvider::class],
            ['id_provider', 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'jenis_provider' => 'Jenis Provider',
            'nama' => 'Nama',
            'kab_kota' => 'Kab/Kota',
            'alamat' => 'Alamat',
            'no_telp' => 'No Telp',
            'web' => 'Web',
            'input_by' => 'Input By',
            'input_date' => 'Input Date',
            'modi_by' => 'Modi By',
            'modi_date' => 'Modi Date',
        ];
    }

    /**
     * Gets query for [[TrPlafons]].
     *
     * @return \yii\db\ActiveQuery|TrPlafonQuery
     */
    public function getTrPlafons()
    {
        return $this->hasMany(TrPlafon::className(), ['id_provider' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return MsProviderQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MsProviderQuery(get_called_class());
    }
	
	public function listJenisProvider(){
		$jabatan=[
			1=>[
				'code'=>'APOTEK'
			],
			2=>[
				'code'=>'DOKTER ANAK'
			],
			3=>[
				'code'=>'DOKTER GIGI'
			],
			4=>[
				'code'=>'KLINIK'
			],
			5=>[
				'code'=>'RUMAH SAKIT'
			]
		];
		return $jabatan;
	}

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id_provider' => 'id']);
    }
}
