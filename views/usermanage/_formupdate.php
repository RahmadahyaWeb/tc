<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User_manage */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-manage-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>


    <div class="row">
        <div class="col-md-4">

            <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'disabled' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'active')->dropDownList(
                ArrayHelper::map($model->listActive(), 'code', 'name'),
                ['prompt' => '-- Pilih Data --', 'id' => 'active']
            ); ?>
        </div>
        <div class="col-md-4">

            <?= $form->field($model, 'user_group')->dropDownList(
                ArrayHelper::map($model->listUserGroup(), 'code', 'name'),
                ['prompt' => '-- Pilih Data --', 'id' => 'user_group', 'disabled' => true]
            ); ?>
        </div>
    </div>
    <?php
    if ($model->user_group == 'admin') {
    ?>
        <div class="row" id="divcmb">
            <div class="col-md-4">
                <?= $form->field($model, 'jabatan')->textInput(['maxlength' => true, 'id' => 'jabatan']) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'alamat')->textarea(['maxlength' => true, 'rows' => 2, 'id' => 'alamat']) ?>
            </div>
            <div class="col-md-4">

            </div>
        </div>
    <?php
    }
    ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>