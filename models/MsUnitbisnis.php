<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ms_unitbisnis".
 *
 * @property string $unit_bisnis
 * @property string $input_by
 * @property string $input_date
 * @property string|null $modi_by
 * @property string|null $modi_date
 *
 * @property MsPeserta[] $msPesertas
 */
class MsUnitbisnis extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ms_unitbisnis';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['unit_bisnis', 'input_by', 'input_date'], 'required'],
            [['input_date', 'modi_date'], 'safe'],
            [['unit_bisnis'], 'string', 'max' => 50],
            [['alias'], 'string', 'max' => 100],
            [['input_by', 'modi_by'], 'string', 'max' => 20],
            [['unit_bisnis'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'unit_bisnis' => 'Unit Bisnis',
            'input_by' => 'Input By',
            'input_date' => 'Input Date',
            'modi_by' => 'Diperbarui Oleh',
            'modi_date' => 'Tanggal Diperbarui',
            'alias' => 'Kode/Alias',
        ];
    }

    /**
     * Gets query for [[MsPesertas]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getMsPesertas()
    {
        return $this->hasMany(MsPeserta::className(), ['unit_bisnis' => 'unit_bisnis']);
    }

    /**
     * {@inheritdoc}
     * @return MsUnitbisnisQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MsUnitbisnisQuery(get_called_class());
    }

    public function getDataByAlias($alias){
        $data = self::find()->where("alias like '%".$alias."%'")->One();
		return $data;
    }
}
