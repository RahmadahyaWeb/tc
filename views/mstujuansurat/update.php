<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MsJenisplafon */

$this->title = 'Update Tujuan Surat: ' . $model->tujuan;
$this->params['breadcrumbs'][] = ['label' => 'Master Tujuan Surat', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->tujuan, 'url' => ['view', 'id' => $model->tujuan]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ms-tujuansurat-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
