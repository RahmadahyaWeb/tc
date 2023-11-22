<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use app\models\User;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php
	$data = User::find()->where('password = :password and id between 1 and 20', ['password'=>'password'])->All();
	//var_dump($data);exit();
	foreach($data as $da){
		$enc = hash_hmac('sha256', $da->username.'password', 'S.Parman');
		$customer = User::find()->where(['username' => $da->username])->one();
		$customer->active = 0;
		$customer->password = $enc;
		$customer->modi_by = 'migration';
		$customer->Update(false);
		//$customer = User::find($da->username)->one();
	}
	$user = 'ADMIN';
	$pass = '3c2020';
	$enc = hash_hmac('sha256', $user.'password', 'S.Parman');
	// $iv= "";
	// $array_iv = array(12, 241, 10, 21, 90, 74, 11, 39);
        // foreach ($array_iv as $value_iv) {
            // $iv .= chr($value_iv);
        // }
	
	// //$enc = User::bencong($pass);
	
	// $key1="Je ne vous oublie pas";
        // $key2="!@#$%!@#$%";
        // $key = substr($key1.$key2,0,24);
	var_dump($enc);
	
	?>

</div>
