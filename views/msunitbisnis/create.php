<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MsUnitBisnis */

$this->title = 'Input Unit Bisnis';
$this->params['breadcrumbs'][] = ['label' => 'Master Unit Bisnis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ms-unit-bisnis-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
