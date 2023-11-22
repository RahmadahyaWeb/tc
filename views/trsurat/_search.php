<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TrPlafonSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tr-plafon-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'id_peserta') ?>

    <?= $form->field($model, 'id_provider') ?>

    <?= $form->field($model, 'tanggal') ?>

    <?= $form->field($model, 'biaya') ?>

    <?php // echo $form->field($model, 'input_by') ?>

    <?php // echo $form->field($model, 'input_date') ?>

    <?php // echo $form->field($model, 'modi_by') ?>

    <?php // echo $form->field($model, 'modi_date') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
