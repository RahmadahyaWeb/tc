<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property string $id
 * @property string $username
 * @property string $password
 * @property string $authKey
 * @property string $accessToken
 * @property string $user_group
 * @property string $last_login
 * @property int $active
 * @property string|null $input_by
 * @property string $input_date
 * @property string|null $modi_by
 * @property string $modi_date
 */
class User_manage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

	public $newpw;
	public $newpw2;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password', 'user_group'], 'required'],
            [['active'], 'integer', 'max'=>1],
            [['id', 'username', 'user_group', 'input_by', 'modi_by'], 'string', 'max' => 20],
            [['username'], 'string', 'max' => 40],
            [['jabatan'], 'string', 'max' => 50],
            [['password'], 'string', 'max' => 100],
            [['alamat'], 'string', 'max' => 100],
            [['authKey'], 'string', 'max' => 10],
            [['accessToken'], 'string', 'max' => 9],
            [['username'], 'unique'],
            [['id'], 'unique'],
			[['newpw','newpw2'], 'safe'],
			[['newpw','newpw2'], 'string', 'min'=>5],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'authKey' => 'Auth Key',
            'accessToken' => 'Access Token',
            'user_group' => 'User Group',
            'last_login' => 'Last Login',
            'active' => 'Active',
            'input_by' => 'Input By',
            'input_date' => 'Input Date',
            'modi_by' => 'Modi By',
            'modi_date' => 'Modi Date',
			'newpw'=> 'New Password',
			'newpw2'=> 'New Password Confirmation',
			'alamat'=> 'Alamat Jabatan',
			'jabatan'=> 'Jabatan User',
        ];
    }

    public function listUserGroup(){
		$sts=[
			1=>[
				'code'=>'default',
				'name'=>'Peserta'
			],
			2=>[
				'code'=>'admin',
				'name'=>'Admin'
			]
		];
		return $sts;
	}

    public function listActive(){
		$sts=[
			1=>[
				'code'=>1,
				'name'=>'Aktif'
			],
			2=>[
				'code'=>0,
				'name'=>'Non-Aktif'
			]
		];
		return $sts;
	}
}
