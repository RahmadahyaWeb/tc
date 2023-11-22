<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MsProviderSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ms-provider-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'jenis_provider') ?>

    <?= $form->field($model, 'nama') ?>

    <?= $form->field($model, 'kab_kota') ?>

    <?= $form->field($model, 'alamat') ?>

    <?php // echo $form->field($model, 'no_telp') ?>

    <?php // echo $form->field($model, 'web') ?>

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
