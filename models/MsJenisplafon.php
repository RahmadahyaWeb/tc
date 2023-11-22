<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ms_jenisplafon".
 *
 * @property int $id
 * @property string $nama_plafon
 * @property string $input_by
 * @property string $input_date
 * @property string|null $modi_by
 * @property string|null $modi_date
 *
 * @property MsPlafon[] $msPlafons
 */
class MsJenisplafon extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ms_jenisplafon';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama_plafon', 'input_by', 'input_date'], 'required'],
            [['input_date'], 'safe'],
            [['nama_plafon', 'input_by', 'modi_by'], 'string', 'max' => 20],
            [['nama_plafon'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'nama_plafon' => 'Nama Plafon',
            'input_by' => 'Input By',
            'input_date' => 'Input Date',
            'modi_by' => 'Modi By',
            'modi_date' => 'Modi Date',
        ];
    }

    /**
     * Gets query for [[MsPlafons]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMsPlafons()
    {
        return $this->hasMany(MsPlafon::className(), ['nama_plafon' => 'nama_plafon']);
    }
	
	public function getTrPlafons()
    {
        return $this->hasMany(TrPlafon::className(), ['nama_plafon' => 'nama_plafon']);
    }
	
	public function getNamaPlafon($nama_plafon){
		$data = self::find()->where("nama_plafon = '".$nama_plafon."'")->One();
		return $data;
	}
}
