<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MsProvider */

$this->title = 'Update Provide: ' . $model->jenis_provider.' - '.$model->nama;
$this->params['breadcrumbs'][] = ['label' => 'Master Provider', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->jenis_provider.' - '.$model->nama, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';

?>
<div class="ms-provider-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formupdate', [
        'model' => $model,
		'listJenisProvider' => $listJenisProvider,
        'cek_akun' => $cek_akun
    ]) ?>

</div>
