<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ms_iuran".
 *
 * @property int $iuran
 * @property string|null $modi_by
 * @property string|null $modi_date
 */
class MsIuran extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ms_iuran';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['iuran'], 'required'],
            [['iuran'], 'integer'],
            [['modi_date'], 'safe'],
            [['modi_by'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'iuran' => 'Iuran',
            'modi_by' => 'Modi By',
            'modi_date' => 'Modi Date',
        ];
    }
}
