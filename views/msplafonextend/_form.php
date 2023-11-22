<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\number\NumberControl;

/* @var $this yii\web\View */
/* @var $model app\models\MsPlafonextend */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ms-plafonextend-form">

	<?php $form = ActiveForm::begin(); ?>

	<?= $form->field($model, 'nama_plafon')->dropDownList(
		$listPlafon,
		['prompt' => '-- Pilih Data --']
	); ?>

	<?= $form->field($model, 'level')->dropDownList(
		$listJabatan,
		['prompt' => '-- Pilih Data --']
	); ?>

	<?= $form->field($model, 'jumlah_anggota')->dropDownList(
		$listAnggota,
		['prompt' => '-- Pilih Data --']
	); ?>

	<?php
	echo '<label>Nominal</label>';
	echo '<div style="width:200px;">';
	echo NumberControl::widget([
		'model' => $model,
		'attribute' => 'nominal',
		'maskedInputOptions' => ['prefix' => 'Rp. '],
	]);
	echo '</div>';
	echo '<br />';
	?>

	<?= $form->field($model, 'keterangan')->textInput(['maxlength' => true]) ?>

	<div class="form-group">
		<?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
	</div>

	<?php ActiveForm::end(); ?>

</div>