<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MsBenefit */
/* @var $form yii\widgets\ActiveForm */

$categories = [
    "Provider" => 'Provider',
    "Peserta"  => 'Peserta',
];

?>

<div class="ms-benefit-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'judul')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'link')->fileInput() ?>

    <?= $form->field($model, 'level_akses')->dropDownList(
    $categories,
    ['prompt' => 'Pilih hak akses']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
