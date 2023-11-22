<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ms_level".
 *
 * @property string $level_jabatan
 * @property string $input_by
 * @property string $input_date
 * @property string|null $modi_by
 * @property string|null $modi_date
 *
 * @property MsPeserta[] $msPesertas
 */
class MsLevel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ms_level';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['level_jabatan'], 'required'],
            [['input_date', 'modi_date'], 'safe'],
            [['level_jabatan', 'input_by', 'modi_by'], 'string', 'max' => 20],
            [['alias'], 'string', 'max' => 200],
            [['level_jabatan'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'level_jabatan' => 'Level Jabatan',
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
        return $this->hasMany(MsPeserta::className(), ['level_jabatan' => 'level_jabatan']);
    }

    /**
     * {@inheritdoc}
     * @return MsLevelQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MsLevelQuery(get_called_class());
    }

    public function getDataByAlias($alias){
        $data = self::find()->where("alias like '%".$alias."%'")->One();
		return $data;
    }
}
