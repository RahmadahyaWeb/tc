<?php

use yii\helpers\Html;
// use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use kartik\form\ActiveForm;
use yii\helpers\Url;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\MsPeserta */

$this->title = 'Sinkron Peserta';
$this->params['breadcrumbs'][] = ['label' => 'Master Peserta', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs(
    "$('#btn-cek').on('click', function() { 
        var kd_anggota = document.getElementById('kode_anggota').value;
        $.ajax({
            url: '". Yii::$app->getUrlManager()->createUrl("mspeserta/getdatasync")."',
            type: 'POST', 
            data: {
                kd_anggota: kd_anggota
            }, 
            success: function(data) {
                var obj = JSON.parse(data);
                if(obj != null){
                    $('#nama_peserta').val(obj.nama_peserta).change();
                    $('#jenis_kelamin').val(obj.jenis_kelamin).change();
                    $('#tempat_lahir').val(obj.tempat_lahir).change();
                    $('#tgl_lahir').val(obj.tgl_lahir).change();
                    $('#alamat').val(obj.alamat).change();
                    $('#level_jabatan').val(obj.level_jabatan).change();
                    $('#departemen').val(obj.departemen).change();
                    $('#unit_bisnis').val(obj.unit_bisnis).change();
                    $('#active').val(obj.active).change();
                } else {
                    alert('Data tidak ditemukan!');
                }
            },
            error: function(exception) {
                console.log(exception);
            }
        })
    });",
    View::POS_READY,
    'my-button-handler'
);
?>
<div class="ms-peserta-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="ms-peserta-form">
        <hr />
        <h3><u>Data Induk</u></h3>
        <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="col-md-4">
                <?= $form->field(
                    $model,
                    'kode_anggota',
                    [
                        'addon' => [
                            'append' => ['content' => '<button type="button" class="btn btn-info" id="btn-cek" name="btn-cek">Tarik Data</button>', 'asButton' => true]
                        ]
                    ]
                )->textInput(['maxlength' => true, 'id' => 'kode_anggota']) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'nama_peserta')->textInput(['maxlength' => true, 'id' => 'nama_peserta']) ?>

            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'jenis_kelamin')->dropDownList(
                    ArrayHelper::map($model->listGender(), 'code', 'name'),
                    ['prompt' => '-- Pilih Data --', 'id'=>'jenis_kelamin']
                ); ?>

            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <?= $form->field($model, 'tempat_lahir')->textInput(['maxlength' => true, 'id'=>'tempat_lahir']) ?>
            </div>
            <div class="col-md-4">

                <?php
                //$model->tgl_lahir = date('Y-m-d');
                echo '<label>Tgl. Lahir</label>';
                echo DatePicker::widget([
                    'model' => $model,
                    'readonly' => true,
                    'attribute' => 'tgl_lahir',
                    'options' => ['placeholder' => 'Pilih Tanggal ...','id'=>'tgl_lahir', 'required'=>true],
                    'pluginOptions' => [
                        'format' => 'yyyy-mm-dd',
                        'autoclose' => true,
                    ]
                ]);
                echo '<div style="color:red;">'.Html::error($model, 'tgl_lahir').'</div>';
                echo '<br />';
                ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'alamat')->textarea(['rows'=>3,'maxlength' => true, 'id'=>'alamat']) ?>
            </div>
        </div>
        <h3><u>Data Keanggotaan</u></h3>
        <div class="row">
            <div class="col-md-3">
                <?= $form->field($model, 'level_jabatan')->dropDownList(
                    $listLevel,
                    ['prompt' => '-- Pilih Data --', 'id' => 'level_jabatan']
                ); ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($model, 'departemen')->dropDownList(
                    $listDepartemen,
                    ['prompt' => '-- Pilih Data --', 'id' => 'departemen']
                ); ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($model, 'unit_bisnis')->dropDownList(
                    $listUnitbisnis,
                    ['prompt' => '-- Pilih Data --', 'id' => 'unit_bisnis']
                ); ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($model, 'active')->dropDownList(
                    ArrayHelper::map($model->listStatus(), 'code', 'name'),
                    ['prompt' => '-- Pilih Data --', 'id' => 'active']
                ); ?>
            </div>
        </div>

        <div class="form-group">
            <?= Html::submitButton('Sinkronkan!', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>