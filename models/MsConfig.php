<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ms_config".
 *
 * @property string $name
 * @property string $value
 * @property string|null $value2
 * @property string $input_by
 * @property string $input_date
 * @property string|null $modi_by
 * @property string|null $modi_date
 */
class MsConfig extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ms_config';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'value', 'input_by', 'input_date'], 'required'],
            [['input_date', 'modi_date'], 'safe'],
            [['name'], 'string', 'max' => 50],
            [['value', 'value2'], 'string', 'max' => 255],
            [['input_by', 'modi_by'], 'string', 'max' => 20],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'value' => 'Value',
            'value2' => 'Value2',
            'input_by' => 'Input By',
            'input_date' => 'Input Date',
            'modi_by' => 'Modi By',
            'modi_date' => 'Modi Date',
        ];
    }
}
