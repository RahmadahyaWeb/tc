<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MsPlafonextendSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ms-plafonextend-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'nama_plafon') ?>

    <?= $form->field($model, 'level') ?>

    <?= $form->field($model, 'jumlah_anggota') ?>

    <?= $form->field($model, 'nominal') ?>

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
