<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\number\NumberControl;


/* @var $this yii\web\View */
/* @var $model app\models\MsPlafon */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ms-plafon-form">

    <?php $form = ActiveForm::begin(); ?>

    
	<?= $form->field($model, 'nama_plafon')->textInput(['maxlength' => true,'disabled'=>true]) ?>
	<?= $form->field($model, 'level')->textInput(['maxlength' => true,'disabled'=>true]) ?>

    <?php
		echo '<label>Nominal</label>';
		echo '<div style="width:200px;">';
		echo NumberControl::widget([
			'model' => $model,
			'attribute' => 'nominal',
			'maskedInputOptions' => ['prefix' => 'Rp. '],
		]);
		echo '</div>';
		echo'<br />';
	?>

	<?= $form->field($model,'keterangan')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
