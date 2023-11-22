<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MsLevel */
/* @var $form yii\widgets\ActiveForm */
//form akan di joinkan
?>

<div class="ms-level-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'level_jabatan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>
    <p style="color:red">Pisahkan alias dengan koma tanpa spasi.</p>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
