<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MsPlafon */
$this->title = 'Input Plafon';
$this->params['breadcrumbs'][] = ['label' => 'Master Plafon', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ms-plafon-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		'listPlafon' => $listPlafon,
		'listJabatan' => $listJabatan,
    ]) ?>

</div>
