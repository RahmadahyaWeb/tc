<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MsPlafonextend */

$this->title = 'Input Plafon';
$this->params['breadcrumbs'][] = ['label' => 'Master Plafon 2', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ms-plafonextend-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		'listPlafon' => $listPlafon,
		'listJabatan' => $listJabatan,
		'listAnggota' => $listAnggota
    ]) ?>

</div>
