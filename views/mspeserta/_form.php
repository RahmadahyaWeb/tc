<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\MsPeserta */
/* @var $form yii\widgets\ActiveForm */
?>
<script type="text/javascript">

function autoDropdown(){
	var ket = document.getElementById("keterangan");
	var strSel = ket.options[ket.selectedIndex].value;
	var lev = document.getElementById("level_jabatan");
	var dep = document.getElementById("departemen");
	var unt = document.getElementById("unit_bisnis");
	var kd_anggota = document.getElementById("kode_anggota").value;
	var x = document.getElementById("divcmb");
	if(strSel != 'PESERTA INDUK'){
		$.ajax({
			url: '<?php echo Yii::$app->getUrlManager()->createUrl("mspeserta/getdatainduk") ?>',
			type: 'POST',  // http method
			data: { kd_anggota: kd_anggota },  // data to submit
			success: function (data) {
				var obj = JSON.parse(data);
				lev.value= obj.level_jabatan;
				dep.value= obj.departemen;
				unt.value= obj.unit_bisnis;
				x.style.display="none";
			},
			error: function (exception) {
				console.log(exception);
			}
		})
		
		//("#level_jabatan option[value='-']").attr('selected', 'selected');
	} else {
		lev.value = '';
		dep.value = '';
		unt.value = '';
		x.style.display="block";
	}
}
</script>
<div class="ms-peserta-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'kode_anggota')->textInput(['maxlength' => true,'id' => 'kode_anggota']) ?>

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
    
	<?= $form->field($model, 'alamat')->textarea(['rows'=>2,'maxlength' => true]) ?>
	
	<?php
	$model->tgl_lahir = date('Y-m-d', strtotime('-23 years'));
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
