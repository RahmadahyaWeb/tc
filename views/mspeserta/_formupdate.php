<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\MsPeserta */
/* @var $form yii\widgets\ActiveForm */
if($model->keterangan =='SUAMI' || $model->keterangan =='ISTRI'){
	$model->keterangan ='SUAMI/ISTRI';
}
?>
<script type="text/javascript">
window.addEventListener("load", function(){
	autoDropdown()		
});
function autoDropdown(){
	var depDefault = document.getElementById("hiddendep").value;
	var levDefault = document.getElementById("hiddenlev").value;
	var untDefault = document.getElementById("hiddenunt").value;
	
	var ket = document.getElementById("keterangan");
    var strSel = ket.options[ket.selectedIndex].value;
	
	var lev = document.getElementById("level_jabatan");
	var dep = document.getElementById("departemen");
	var unt = document.getElementById("unit_bisnis");
	var x = document.getElementById("divcmb");
	if(strSel != 'PESERTA INDUK'){
		// lev.value= '-';
		// dep.value= '-';
		// unt.value= '-';
		x.style.display="none";
		//("#level_jabatan option[value='-']").attr('selected', 'selected');
	} else {
		lev.value = levDefault;
		dep.value = depDefault;
		unt.value = untDefault;
		x.style.display="block";
	}
	
}
</script>
<div class="ms-peserta-form">

    <?php $form = ActiveForm::begin(); ?>
	
	<?php 
		echo Html::hiddenInput('hiddendep', $model->departemen,array('id' => 'hiddendep')); 
		echo Html::hiddenInput('hiddenunt', $model->unit_bisnis,array('id' => 'hiddenunt')); 
		echo Html::hiddenInput('hiddenlev', $model->level_jabatan,array('id' => 'hiddenlev'));
	?>

    <?= $form->field($model, 'kode_anggota')->textInput(['maxlength' => true, 'disabled'=>true]) ?>

    <?= $form->field($model, 'nama_peserta')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'keterangan')->dropDownList(
			ArrayHelper::map($model->listKeterangan(),'code','name'),
			['prompt'=>'-- Pilih Data --','id' => 'keterangan', 'onchange' =>'autoDropdown();']
        ); ?>

    <?= $form->field($model, 'jenis_kelamin')->dropDownList(
			ArrayHelper::map($model->listGender(),'code','name'),
			['prompt'=>'-- Pilih Data --']
        ); ?>

    <?= $form->field($model, 'tempat_lahir')->textInput(['maxlength' => true]) ?>
	
	<?php
	//$model->tgl_lahir = date('Y-m-d', strtotime('-23 years'));
	echo '<label>Tgl. Lahir</label>';
	echo DatePicker::widget([
		'model'=>$model,
		'readonly'=>true,
		'attribute' => 'tgl_lahir', 
		'options' => ['placeholder' => 'Pilih Tanggal ...'],
		'pluginOptions' => [
			'format' => 'yyyy-mm-dd',
			'todayHighlight' => true,
			'autoclose'=>true,
		]
	]);
	echo '<br />';
	?>
	<div id = "divcmb">

	<?= $form->field($model, 'alamat')->textarea(['rows'=>2,'maxlength' => true]) ?>
	
    <?= $form->field($model, 'level_jabatan')->dropDownList(
			$listLevel,
			['prompt'=>'-- Pilih Data --','id' => 'level_jabatan']
        ); ?>
		
	<?= $form->field($model, 'departemen')->dropDownList(
			$listDepartemen,
			['prompt'=>'-- Pilih Data --','id' => 'departemen']
        ); ?>

	<?= $form->field($model, 'unit_bisnis')->dropDownList(
			$listUnitbisnis,
			['prompt'=>'-- Pilih Data --','id' => 'unit_bisnis']
        ); ?>
	</div>
	<?= $form->field($model, 'active')->dropDownList(
			ArrayHelper::map($model->listStatus(),'code','name'),
			['prompt'=>'-- Pilih Data --']
        ); ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
