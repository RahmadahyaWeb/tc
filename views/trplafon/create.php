<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\number\NumberControl;
use kartik\date\DatePicker;

$this->title = 'Input Trans';
$this->params['breadcrumbs'][] = ['label' => 'Trans Plafon', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tr-plafon-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="tr-plafon-form">

        <?php $form = ActiveForm::begin(); ?>
        <div class="row">
			<div class="col-md-4">
                <?= $form->field($model, 'id_peserta')->dropDownList(
                    $listPeserta,
                    ['prompt'=>'-- Pilih Data --']
                ); ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'nama_plafon')->dropDownList(
                    $listJenisPlafon,
                    ['prompt'=>'-- Pilih Data --']
                ); ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'id_provider')->dropDownList(
                    $listProvider,
                    ['prompt'=>'-- Pilih Data --']
                ); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
            <?php
                $model->tanggal = date('Y-m-d');
                echo '<label>Tanggal Mulai</label>';
                echo DatePicker::widget([
                    'model'=>$model,
                    'readonly'=>true,
                    'attribute' => 'tanggal', 
                    'options' => ['placeholder' => 'Pilih Tanggal ...'],
                    'pluginOptions' => [
                        'format' => 'yyyy-mm-dd',
                        'todayHighlight' => true,
                        'autoclose'=>true,
                        'orientation'=> "bottom"
                    ]
                ]);       
            ?>
            </div>
            <div class="col-md-4">
            <?php
                $model->tanggal_selesai = date('Y-m-d');
                echo '<label>Tanggal Selesai</label>';
                echo DatePicker::widget([
                    'model'=>$model,
                    'readonly'=>true,
                    'attribute' => 'tanggal_selesai', 
                    'options' => ['placeholder' => 'Pilih Tanggal ...'],
                    'pluginOptions' => [
                        'format' => 'yyyy-mm-dd',
                        'todayHighlight' => true,
                        'autoclose'=>true,
                        'orientation'=> "bottom"
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
        </div>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>


</div>
