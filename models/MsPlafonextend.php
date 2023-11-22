<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ms_plafonextend".
 *
 * @property int $id
 * @property string $nama_plafon
 * @property string $level
 * @property int $jumlah_anggota
 * @property int $nominal
 * @property string $input_by
 * @property string $input_date
 * @property string|null $modi_by
 * @property string|null $modi_date
 */
class MsPlafonextend extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ms_plafonextend';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama_plafon', 'level', 'jumlah_anggota', 'nominal', 'input_by', 'input_date'], 'required'],
            [['jumlah_anggota', 'nominal'], 'integer'],
            [['input_date', 'modi_date'], 'safe'],
            [['nama_plafon'], 'string', 'max' => 60],
            [['keterangan'], 'string', 'max' => 100],
            [['level'], 'string', 'max' => 15],
            [['input_by'], 'string', 'max' => 20],
            [['modi_by'], 'string', 'max' => 10],
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
            'jumlah_anggota' => 'Jumlah Anggota',
            'nominal' => 'Nominal',
            'input_by' => 'Input By',
            'input_date' => 'Input Date',
            'modi_by' => 'Modi By',
            'modi_date' => 'Modi Date',
        ];
    }

	public function getDataPlafon($nama_plafon, $level, $jumlah_anggota){
		$data = self::find()->where("nama_plafon = '".$nama_plafon."'")
			->andWhere("level = '".$level."'")
			->andWhere("jumlah_anggota = '".$jumlah_anggota."'")
			->One();
		return $data;
	}
}
