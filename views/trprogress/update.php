<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\number\NumberControl;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\TrProgress */

$this->title = 'Update Tr Progress: ' . $model->resi;
$this->params['breadcrumbs'][] = ['label' => 'Tr Progresses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->resi, 'url' => ['view', 'id' => $model->resi]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tr-progress-update">

    <div class="tr-progress-form">

        <?php $form = ActiveForm::begin(); ?>

        <div class="row">
			<div class="col-md-4">
            <?php
                echo '<label>Tanggal Kwitansi</label>';
                echo DatePicker::widget([
                    'model'=>$model,
                    'readonly'=>true,
                    'attribute' => 'tanggal', 
                    'options' => ['placeholder' => 'Pilih Tanggal ...'],
                    'pluginOptions' => [
                        'format' => 'yyyy-mm-dd',
                        'todayHighlight' => true,
                        'autoclose'=>true,
                    ]
                ]);       
            ?>
            </div>
            <div class="col-md-4">
            <?php
                echo '<label>Biaya</label>';
                echo NumberControl::widget([
                    'model' => $model,
                    'attribute' => 'biaya',
                    'maskedInputOptions' => ['prefix' => 'Rp. '],
                ]);
                echo '<br />';
            ?>
            </div>
            <div class="col-md-4">
                <?php 
                    echo $form->field($model, 'status')->dropDownList(
                        $listStatus,
                        ['prompt'=>'-- Pilih Data --','id' => 'status']
                    ); 
                ?>
            </div>
        </div>
        <div class="row">
            <input type="hidden" value =" <?= $model->progress?>" id="progress_awal" />
            <div class="col-md-4">
                <?= $form->field($model, 'ket_app')->textarea(['rows' => '4']) ?>
            </div>
			<div class="col-md-4">
                <?php 
                    echo $form->field($model, 'progress')->dropDownList(
                        $listProgress,
                        ['prompt'=>'-- Pilih Data --','id' => 'progress', 'onchange' =>'autoDropdown();']
                    ); 
                ?>
            </div>
            <div class="col-md-4">
				<div id ="tgl_terima" style="display:<?php if($model->progress == 1){ echo "block"; } else { echo "none"; } ?>">
                <?php
                    echo '<label>Tgl. Terima</label>';
                    echo DatePicker::widget([
                        'model'=>$model,
                        'readonly'=>true,
                        'attribute' => 'progress_1', 
                        'options' => ['placeholder' => 'Pilih Tanggal ...'],
                        'pluginOptions' => [
                            'format' => 'yyyy-mm-dd',
                            'todayHighlight' => true,
                            'autoclose'=>true,
                        ]
                    ]);
                    echo '<br />';      
                ?>
                </div>
				<div id ="tgl_verval" style="display:<?php if($model->progress == 2){ echo "block"; } else { echo "none"; } ?>">
                <?php
                    echo '<label>Tgl. Verval</label>';
                    echo DatePicker::widget([
                        'model'=>$model,
                        'readonly'=>true,
                        'attribute' => 'progress_2', 
                        'options' => ['placeholder' => 'Pilih Tanggal ...'],
                        'pluginOptions' => [
                            'format' => 'yyyy-mm-dd',
                            'todayHighlight' => true,
                            'autoclose'=>true,
                        ]
                    ]);
                    echo '<br />';      
                ?>
                </div>
				<div id ="tgl_prosesfinance" style="display:<?php if($model->progress == 3){ echo "block"; } else { echo "none"; } ?>">
                <?php
                    echo '<label>Tgl. Verval</label>';
                    echo DatePicker::widget([
                        'model'=>$model,
                        'readonly'=>true,
                        'attribute' => 'progress_3', 
                        'options' => ['placeholder' => 'Pilih Tanggal ...'],
                        'pluginOptions' => [
                            'format' => 'yyyy-mm-dd',
                            'todayHighlight' => true,
                            'autoclose'=>true,
                        ]
                    ]);
                    echo '<br />';      
                ?>
                </div>
                <div id ="tgl_pencairan" style="display:<?php if($model->progress == 4){ echo "block"; } else { echo "none"; } ?>">
                <?php
                    echo '<label>Tgl. Pencairan</label>';
                    echo DatePicker::widget([
                        'model'=>$model,
                        'readonly'=>true,
                        'attribute' => 'progress_4', 
                        'options' => ['placeholder' => 'Pilih Tanggal ...'],
                        'pluginOptions' => [
                            'format' => 'yyyy-mm-dd',
                            'todayHighlight' => true,
                            'autoclose'=>true,
                        ]
                    ]);
                    echo '<br />';      
                ?>
                </div>
				
            </div>
        </div>
        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success','onclick' => 'return validasi()']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<script type="text/javascript">
function validasi() {
	var stts = document.getElementById("status");
	var status = stts.options[stts.selectedIndex].value;
    var prg2 = document.getElementById("progress");
	var progress2 = prg2.options[prg2.selectedIndex].value.trim();
    var progress1 = document.getElementById("progress_awal").value.trim();
    if(progress1 == progress2){
        return true;
    } else {
        if(status != 'Approved'){
            alert("Status Bukan Approved! Progress tidak bisa dilanjutkan.");
            return false;
        } else {
            return true;
	    }
    }
    
	return false;
};
function autoDropdown(){
	var ket = document.getElementById("progress");
	var strSel = ket.options[ket.selectedIndex].value;
	var x4 = document.getElementById("tgl_pencairan");
	var x3 = document.getElementById("tgl_prosesfinance");
	var x2 = document.getElementById("tgl_verval");
	var x1 = document.getElementById("tgl_terima");
	if(strSel == 4){
		x4.style.display="block";
		x3.style.display="none";
		x2.style.display="none";
		x1.style.display="none";
	} else if(strSel == 3){
		x4.style.display="none";
		x3.style.display="block";
		x2.style.display="none";
		x1.style.display="none";
	} else if(strSel == 2){
		x4.style.display="none";
		x3.style.display="none";
		x2.style.display="block";
		x1.style.display="none";
	} else if(strSel == 1){
		x4.style.display="none";
		x3.style.display="none";
		x2.style.display="none";
		x1.style.display="block";
	} else {
		x4.style.display="none";
		x3.style.display="none";
		x2.style.display="none";
		x1.style.display="none";
	}
}
</script>
