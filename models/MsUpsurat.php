<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "ms_upsurat".
 *
 * @property int $id
 * @property string $up
 * @property string $input_by
 * @property string $input_date
 * @property string|null $modi_by
 * @property string|null $modi_date
 *
 * @property MsUpsurat[] $msUpsurats
 */
class MsUpsurat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ms_upsurat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['up', 'input_by', 'input_date'], 'required'],
            [['input_date'], 'safe'],
            [['input_by', 'modi_by'], 'string', 'max' => 20],
            [['up'], 'string', 'max' => 100],
            [['up'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'up' => 'Up Surat / Penerima',
            'input_by' => 'Input By',
            'input_date' => 'Input Date',
            'modi_by' => 'Modi By',
            'modi_date' => 'Modi Date',
        ];
    }

    /**
     * Gets query for [[MsUpsurats]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMsUpsurats()
    {
        return $this->hasMany(MsUpsurat::class, ['up' => 'up']);
    }

    public function listUpSurat(){
        return  ArrayHelper::map(self::find()
			->select(['up'])
			->orderBy('up')
			->all(),'up','up');
    }
}
