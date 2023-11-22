<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "ms_tujuansurat".
 *
 * @property int $id
 * @property string $tujuan
 * @property string $input_by
 * @property string $input_date
 * @property string|null $modi_by
 * @property string|null $modi_date
 *
 * @property MsTujuansurat[] $msTujuansurats
 */
class MsTujuansurat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ms_tujuansurat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tujuan', 'input_by', 'input_date'], 'required'],
            [['input_date'], 'safe'],
            [['input_by', 'modi_by'], 'string', 'max' => 20],
            [['tujuan'], 'string', 'max' => 100],
            [['tujuan'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'tujuan' => 'Tujuan Surat / Penerima',
            'input_by' => 'Input By',
            'input_date' => 'Input Date',
            'modi_by' => 'Modi By',
            'modi_date' => 'Modi Date',
        ];
    }

    /**
     * Gets query for [[MsTujuansurats]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMsTujuansurats()
    {
        return $this->hasMany(MsTujuansurat::class, ['tujuan' => 'tujuan']);
    }
	
	public function getNamaTujuansurat($tujuan){
		$data = self::find()->where("tujuan = '".$tujuan."'")->One();
		return $data;
	}

    public function listTujuanSurat(){
        return ArrayHelper::map(self::find()
			->select(['tujuan'])
			->orderBy('tujuan')
			->all(),'tujuan','tujuan');
    }
}
