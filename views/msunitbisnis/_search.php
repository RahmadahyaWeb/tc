<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MsUnitBisnisSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ms-unit-bisnis-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'unit_bisnis') ?>

    <?= $form->field($model, 'input_by') ?>

    <?= $form->field($model, 'input_date') ?>

    <?= $form->field($model, 'modi_by') ?>

    <?= $form->field($model, 'modi_date') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
