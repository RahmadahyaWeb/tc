<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ms_benefit".
 *
 * @property int $id
 * @property string $judul
 * @property string $link
 * @property string $create_by
 * @property string $create_time
 * @property string|null $modif_by
 * @property string|null $modif_time
 */
class MsBenefit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $link_file;

    public static function tableName()
    {
        return 'ms_benefit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['judul', 'link', 'create_by', 'create_time', 'level_akses'], 'required'],
            [['create_time', 'modif_time'], 'safe'],
            [['judul', 'link'], 'string', 'max' => 100],
            [['create_by', 'modif_by'], 'string', 'max' => 50],
            [['link_file'], 'file', 'skipOnEmpty'=>false, 'extensions'=> 'pdf'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'judul' => 'Judul',
            'link' => 'Link',
            'create_by' => 'Create By',
            'create_time' => 'Create Time',
            'link_file' => 'Link File',
            'modif_by' => 'Modif By',
            'modif_time' => 'Modif Time',
            'level_akses' => 'Level Akses'
        ];
    }
}
