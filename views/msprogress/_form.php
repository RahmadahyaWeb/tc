<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MsProgress */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ms-progress-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'progress')->textInput() ?>

    <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
