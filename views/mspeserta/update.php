<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MsPeserta */

$this->title = 'Update Peserta: ' . $model->kode_anggota .' - '.$model->nama_peserta;
$this->params['breadcrumbs'][] = ['label' => 'Master Peserta', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->kode_anggota, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ms-peserta-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formupdate', [
        'model' => $model,
		'listDepartemen' => $listDepartemen,
		'listUnitbisnis' => $listUnitbisnis,
		'listLevel' => $listLevel
    ]) ?>

</div>
