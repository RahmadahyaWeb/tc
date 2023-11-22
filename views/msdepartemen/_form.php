<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MsDepartemen */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ms-departemen-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'departemen')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>
    <p style="color:red">Pisahkan alias dengan koma tanpa spasi.</p>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
