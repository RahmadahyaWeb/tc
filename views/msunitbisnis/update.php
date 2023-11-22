<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MsUnitBisnis */

$this->title = 'Update Unit Bisnis: ' . $model->unit_bisnis;
$this->params['breadcrumbs'][] = ['label' => 'Master Unit Bisnis', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->unit_bisnis, 'url' => ['view', 'id' => $model->unit_bisnis]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ms-unit-bisnis-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
