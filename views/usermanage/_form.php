<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User_manage */
/* @var $form yii\widgets\ActiveForm */
?>
<script type="text/javascript">

function autoDropdown(){
	var ket = document.getElementById("user_group");
	var jab = document.getElementById("jabatan");
	var alm = document.getElementById("alamat");
    jab.value = "";
    alm.value = "";
	var strSel = ket.options[ket.selectedIndex].value;
	var x = document.getElementById("divcmb");
	if(strSel == 'default'){
		x.style.display="none";
		//("#level_jabatan option[value='-']").attr('selected', 'selected');
	} else {
		x.style.display="block";
	}
}
</script>
<div class="user-manage-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->hiddenInput(['value' => null])->label(false) ?>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">

            <?php //echo $form->field($model, 'user_group')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'user_group')->dropDownList(
			ArrayHelper::map($model->listUserGroup(),'code','name'),
			['prompt'=>'-- Pilih Data --','id' => 'user_group', 'onchange' =>'autoDropdown();']
        ); ?>
        </div>
    </div>
    <div class="row" id="divcmb" style="display:none">
        <div class="col-md-4">
            <?= $form->field($model, 'jabatan')->textInput(['maxlength' => true, 'id' => 'jabatan']) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'alamat')->textarea(['maxlength' => true, 'rows'=>2, 'id' => 'alamat']) ?>
        </div>
        <div class="col-md-4">

        </div>
    </div>
    <?= $form->field($model, 'last_login')->hiddenInput(['value' => null])->label(false) ?>

    <?= $form->field($model, 'active')->hiddenInput(['value' => '0'])->label(false) ?>

    <?= $form->field($model, 'input_by')->hiddenInput(['value' => 'admin'])->label(false) ?>

    <?= $form->field($model, 'modi_by')->hiddenInput(['value' => 'admin'])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>