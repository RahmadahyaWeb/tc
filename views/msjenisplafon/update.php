<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MsJenisplafon */

$this->title = 'Update Jenis Plafon: ' . $model->nama_plafon;
$this->params['breadcrumbs'][] = ['label' => 'Master Jenis Plafon', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nama_plafon, 'url' => ['view', 'id' => $model->nama_plafon]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ms-jenisplafon-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
