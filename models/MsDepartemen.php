<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ms_departemen".
 *
 * @property string $departemen
 * @property string $input_by
 * @property string $input_date
 * @property string|null $modi_by
 * @property string|null $modi_date
 *
 * @property MsPeserta[] $msPesertas
 */
class MsDepartemen extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ms_departemen';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['departemen', 'input_by', 'input_date'], 'required'],
            [['input_date', 'modi_date'], 'safe'],
            [['departemen'], 'string', 'max' => 50],
            [['alias'], 'string', 'max' => 200],
            [['input_by', 'modi_by'], 'string', 'max' => 20],
            [['departemen'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'departemen' => 'Departemen',
            'input_by' => 'Input By',
            'input_date' => 'Input Date',
            'modi_by' => 'Diperbarui Oleh',
            'modi_date' => 'Tanggal Diperbarui',
            'alias' => 'Alias/Kode',
        ];
    }

    /**
     * Gets query for [[MsPesertas]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getMsPesertas()
    {
        return $this->hasMany(MsPeserta::className(), ['departemen' => 'departemen']);
    }

    /**
     * {@inheritdoc}
     * @return MsDepartemenQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MsDepartemenQuery(get_called_class());
    }
    
    public function getDataByAlias($alias){
        $data = self::find()->where("alias like '%".$alias."%'")->One();
		return $data;
    }
}
