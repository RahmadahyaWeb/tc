<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ms_nonbenefit".
 *
 * @property int $id
 * @property string $value
 * @property string $input_by
 * @property string $input_date
 * @property string|null $modi_by
 * @property string|null $mode_date
 */
class MsNonbenefit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ms_nonbenefit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['value', 'input_by', 'input_date'], 'required'],
            [['input_date', 'modi_date'], 'safe'],
            [['value'], 'string', 'max' => 255],
            [['input_by', 'modi_by'], 'string', 'max' => 20],
            [['value'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'value' => 'Value',
            'input_by' => 'Input By',
            'input_date' => 'Input Date',
            'modi_by' => 'Modi By',
            'mode_date' => 'Mode Date',
        ];
    }
}
