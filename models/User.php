<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property string $id
 * @property string $password
 * @property string $last_login
 * @property int $active
 * @property string|null $input_by
 * @property string $input_date
 * @property string|null $modi_by
 * @property string $modi_date
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // [['id', 'password', 'last_login'], 'required'],
            // [['last_login', 'input_date', 'modi_date'], 'safe'],
            // [['active'], 'integer'],
            // [['id', 'input_by', 'modi_by'], 'string', 'max' => 20],
            [['password'], 'string', 'min' => 5],
            // [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        // return [
            // 'id' => 'ID',
            // 'password' => 'Password',
            // 'last_login' => 'Last Login',
            // 'active' => 'Active',
            // 'input_by' => 'Input By',
            // 'input_date' => 'Input Date',
            // 'modi_by' => 'Modi By',
            // 'modi_date' => 'Modi Date',
        // ];
    }
	
	public static function findIdentity($id)
    {
		$res = self::find()
		->where(['id' => $id])
		->asArray()
		->one();
		return isset($res['id']) ? new static($res) : null;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
		$res = self::find()
		->where(['accessToken' => $token])
		->asArray()
		->one();	
		if ($res['accessToken'] === $token) {
			return new static($res);
		}
        return null;
    }
		
	public static function findByUsername($username)
    {
		$user = self::find()
            ->where(['username' => $username])
            ->asArray()
            ->one();
        
        return $user ? new static($user) : null;
    }
	
	public function getId()
    {
		return $this->id;
		
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }
	
	public function validatePassword($user,$password)
    {
	
		return $this->encong($user,$password) === $this->password;
		//return $this->password === $password;
    }
	
	public function encong($id, $pass_str){
		$password = hash_hmac('sha256', $id.$pass_str, 'S.Parman');
		return $password;
	}

    public function getProvider()
    {
        return $this->hasOne(MsProvider::className(), ['id' => 'id_provider']);
    }
}
