<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "ms_progress".
 *
 * @property int $progress
 * @property string $status
 *
 * @property TrProgress[] $trProgresses
 */
class MsProgress extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ms_progress';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['progress', 'status'], 'required'],
            [['progress'], 'integer'],
            [['status'], 'string', 'max' => 40],
            [['progress'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'progress' => 'Progress',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[TrProgresses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTrProgresses()
    {
        return $this->hasMany(TrProgress::className(), ['progress' => 'progress']);
    }

    public function listProgress(){
		$data = self::find()
			->select(['progress', 'status'])
			->orderBy('progress')
			->all();
		return ArrayHelper::map($data,'progress','status');

	}

    public function listStatus(){
		$status=[
			1=>[
				'code'=>'OnProgress',
				'name'=>'OnProgress'
			],
			2=>[
				'code'=>'Approved',
				'name'=>'Approved'
			],
			3=>[
				'code'=>'Rejected',
				'name'=>'Rejected'
			]
		];
		return ArrayHelper::map($status,'code','name');
	}
}
