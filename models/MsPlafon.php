<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ms_plafon".
 *
 * @property int $id
 * @property int $id_plafon
 * @property string $level
 * @property int $nominal
 * @property string $input_by
 * @property string $input_date
 * @property string|null $modi_by
 * @property string|null $modi_date
 *
 * @property MsJenisplafon $plafon
 */
class MsPlafon extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ms_plafon';
    }
    /**
     * {@inheritdoc}
     */
	public $nm_plafon;
	 
    public function rules()
    {
        return [
            [['nama_plafon', 'level', 'nominal'], 'required'],
            [['nominal'], 'integer'],
			[['nama_plafon'], 'string'],
            [['level'], 'string', 'max' => 15],
            [['keterangan'], 'string', 'max' => 100],
            [['input_by'], 'string', 'max' => 20],
            [['modi_by'], 'string', 'max' => 10],
            [['nama_plafon'], 'exist', 'skipOnError' => true, 'targetClass' => MsJenisplafon::className(), 'targetAttribute' => ['nama_plafon' => 'nama_plafon']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama_plafon' => 'Nama Plafon',
            'level' => 'Level',
            'nominal' => 'Nominal',
            'input_by' => 'Input By',
            'input_date' => 'Input Date',
            'modi_by' => 'Modi By',
            'modi_date' => 'Modi Date',
        ];
    }
    /**
     * Gets query for [[Plafon]].
     *
     * @return \yii\db\ActiveQuery
     */
    // public function getMsJenisPlafon()
    // {
        // return $this->hasOne(MsJenisplafon::className(), ['nama_plafon' => 'nama_plafon']);
    // }
	
	public function listPlafon(){
		$jabatan=[
			1=>[
				'code'=>'1',
				'name'=>'Aktif'
			],
			2=>[
				'code'=>'0',
				'name'=>'Non Aktif'
			]
		];
		return $jabatan;
	}
	
	public function listJabatan(){
		$jabatan=[
			1=>[
				'code'=>'GENERAL MANAGER',
				'name'=>'General Manager'
			],
			2=>[
				'code'=>'MANAGER',
				'name'=>'Manager'
			],
			3=>[
				'code'=>'STAFF',
				'name'=>'Staff'
			]
		];
		return $jabatan;
	}
	
	public function getNamaPlafon($nama_plafon){
		$data = self::find()->where("nama_plafon = '".$nama_plafon."'")->One();
		return $data;
	}
	
	public function getDataPlafon($nama_plafon, $level){
		$data = self::find()->where("nama_plafon = '".$nama_plafon."'")
			->andWhere("level = '".$level."'")
			->One();
		return $data;
	}
}
