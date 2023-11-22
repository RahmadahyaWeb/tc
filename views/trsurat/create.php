<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\number\NumberControl;
use kartik\date\DatePicker;

$this->title = 'Buat Surat';
$this->params['breadcrumbs'][] = ['label' => 'Manajemen Surat Online', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$model->tgl_kuitansi = date('Y-m-d');
$model->tgl_exp1 = date('Y-m-d');
$model->tgl_exp2 = date('Y-m-d');

?>
<script type="text/javascript">
    function columnvalidation() {
        var ket = document.getElementById("jenis_surat");
        var strSel = ket.options[ket.selectedIndex].value;
        var tujuan = document.getElementById("tujuan_surat");
        var tujuan_surat = tujuan.options[tujuan.selectedIndex].value;
        var up = document.getElementById("up_surat");
        var up_surat = up.options[up.selectedIndex].value;
        var tgl_surat = document.getElementById("tgl_surat");
        var tgl_kuitansi = document.getElementById("tgl_kuitansi");
        var tgl_terimaclaim = document.getElementById("tgl_terimaclaim");
        var nominal_reject = document.getElementById("nominal_reject");
        var keterangan_reject = document.getElementById("keterangan_reject");
        var tgl_kuitansipengantar = document.getElementById("tgl_kuitansipengantar");
        var tgl_berlaku = document.getElementById("tgl_berlaku");
        var tgl_expired = document.getElementById("tgl_expired");
        var result = false;
        var message = "";
        if (strSel == '') {
            message = "Jenis Surat Harus Diisi"
            if (message == "") {
                return true;
            } else {
                alert(message);
                return false;
            }
        } else if (strSel == 'Surat Klaim Reject') {
            if (tgl_surat.value == '') {
                message = message + "- Tgl. Surat Harus diisi\n"
            }
            if (tgl_kuitansi.value == '') {
                message = message + "- Tgl. Kuitansi Harus diisi\n"
            }
            if (tgl_terimaclaim.value == '') {
                message = message + "- Tgl. Terima Claim Harus diisi\n"
            }
            if (nominal_reject.value == '') {
                message = message + "- Nominal Reject Harus diisi\n"
            }
            if (keterangan_reject.value == '') {
                message = message + "- Keterangan Reject Harus diisi\n"
            }
            if (message == "") {
                return true;
            } else {
                alert(message);
                return false;
            }
        } else if (strSel == 'Surat Pengantar Berobat') {
            if (tgl_surat.value == '') {
                message = message + "- Tgl. Surat Harus diisi\n"
            }
            if (tgl_kuitansipengantar.value == '') {
                message = message + "- Tgl. Kuitansi/Cetak Harus diisi\n"
            }
            if (tgl_berlaku.value == '') {
                message = message + "- Tgl. Berlaku Harus diisi\n"
            }
            if (tgl_expired.value == '') {
                message = message + "- Tgl. Expired Harus diisi\n"
            }
            if (message == "") {
                return true;
            } else {
                alert(message);
                return false;
            }
        } else {
            if (tgl_surat.value == '') {
                message = message + "- Tgl. Surat Harus diisi\n"
            }
            if (tujuan_surat == '') {
                message = message + "- Tujuan Surat Harus diisi\n"
            }
            if (up_surat == '') {
                message = message + "- UP Surat Harus diisi\n"
            }
            if (message == "") {
                return true;
            } else {
                alert(message);
                return false;
            }
        }
        return false;
    }

    function autoDropdown() {
        document.getElementById("tgl_kuitansipengantar").disabled = false;
        var ket = document.getElementById("jenis_surat");
        var strSel = ket.options[ket.selectedIndex].value;
        var w = document.getElementById("div-default");
        var x = document.getElementById("div-reject");
        var y = document.getElementById("div-pengantar");
        if (strSel == '') {
            w.style.display = "none";
            x.style.display = "none";
            y.style.display = "none";
        } else if (strSel == 'Surat Klaim Reject') {
            w.style.display = "none";
            x.style.display = "block";
            y.style.display = "none";
            document.getElementById("tgl_kuitansipengantar").disabled = true;
        } else if (strSel == 'Surat Pengantar Berobat') {
            w.style.display = "none";
            x.style.display = "none";
            y.style.display = "block";
        } else {
            w.style.display = "block";
            x.style.display = "none";
            y.style.display = "none";
        }
    }
</script>
<div class="tr-plafon-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="tr-plafon-form">

        <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="col-md-3">
                <?= $form->field(
                    $model,
                    'no_surat',
                    [
                        'addon' => [
                            'append' => ['content' => '/TMHRD-TRC/' . $bulan . '/' . date("Y")]
                        ]
                    ]
                )->textInput(['maxlength' => true, 'id' => 'no_surat']) ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($model, 'jenis_surat')->dropDownList(
                    $listJenisSurat,
                    ['prompt' => '-- Pilih Data --', 'id' => 'jenis_surat', 'onchange' => 'autoDropdown();']
                ); ?>
            </div>
            <div class="col-md-3" style="margin-bottom:15px">
                <?php
                $model->tgl_surat = date('Y-m-d');
                echo '<label>Tanggal Surat <span style="color:red">*</span></label>';
                echo DatePicker::widget([
                    'model' => $model,
                    'readonly' => true,
                    'attribute' => 'tgl_surat',
                    'options' => ['placeholder' => 'Pilih Tanggal ...', 'id' => 'tgl_surat'],
                    'pluginOptions' => [
                        'format' => 'yyyy-mm-dd',
                        'todayHighlight' => true,
                        'autoclose' => true,
                        'orientation' => "bottom"
                    ]
                ]);
                ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($model, 'id_peserta')->dropDownList(
                    $listPeserta,
                    ['prompt' => '-- Pilih Data --']
                ); ?>
            </div>
        </div>
        <div class="row" style="display:none" id="div-reject">
            <div class="col-md-3" style="margin-bottom:15px">
                <?php
                echo '<label>Tanggal Kuitansi <span style="color:red">*</span></label>';
                echo DatePicker::widget([
                    'model' => $model,
                    'readonly' => true,
                    'attribute' => 'tgl_kuitansi',
                    'options' => ['placeholder' => 'Pilih Tanggal ...', 'id' => 'tgl_kuitansi'],
                    'pluginOptions' => [
                        'format' => 'yyyy-mm-dd',
                        'todayHighlight' => true,
                        'autoclose' => true,
                        'orientation' => "bottom"
                    ]
                ]);
                ?>
            </div>
            <div class="col-md-3" style="margin-bottom:15px">
                <?php
                $model->tgl_terimaclaim = date('Y-m-d');
                echo '<label>Tanggal Terima Claim <span style="color:red">*</span></label>';
                echo DatePicker::widget([
                    'model' => $model,
                    'readonly' => true,
                    'attribute' => 'tgl_terimaclaim',
                    'options' => ['placeholder' => 'Pilih Tanggal ...', 'id' => 'tgl_terimaclaim'],
                    'pluginOptions' => [
                        'format' => 'yyyy-mm-dd',
                        'todayHighlight' => true,
                        'autoclose' => true,
                        'orientation' => "bottom"
                    ]
                ]);
                ?>
            </div>
            <div class="col-md-3">
                <?php
                echo '<label>Nominal Reject <span style="color:red">*</span></label>';
                echo NumberControl::widget([
                    'model' => $model,
                    'attribute' => 'nominal_reject',
                    'options' => ['id' => 'nominal_reject'],
                    'maskedInputOptions' => ['prefix' => 'Rp. '],

                ]);
                echo '<br />';
                ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($model, 'keterangan_reject')->textarea(['rows' => '3', 'maxlength' => true, 'id' => 'keterangan_reject'])->label('Keterangan Reject <span style="color:red">*</span>') ?>
            </div>
        </div>
        <div class="row" style="display:none" id="div-default">
            <div class="col-md-6">
                <?= $form->field($model, 'tujuan_surat')->dropDownList(
                    $listTujuanSurat,
                    ['prompt' => '-- Pilih Data --', 'id' => 'tujuan_surat']
                )->label('Tujuan <span style="color:red">*</span>'); ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'up_surat')->dropDownList(
                    $listUpSurat,
                    ['prompt' => '-- Pilih Data --', 'id' => 'up_surat']
                )->label('UP <span style="color:red">*</span>'); ?>
            </div>
        </div>
        <div class="row" style="display:none" id="div-pengantar">
            <div class="col-md-4" style="margin-bottom:15px">
                <?php

                echo '<label>Tanggal Cetak Surat <span style="color:red">*</span></label>';
                echo DatePicker::widget([
                    'model' => $model,
                    'readonly' => true,
                    'attribute' => 'tgl_kuitansi',
                    'options' => ['placeholder' => 'Pilih Tanggal ...', 'id' => 'tgl_kuitansipengantar'],
                    'pluginOptions' => [
                        'format' => 'yyyy-mm-dd',
                        'todayHighlight' => true,
                        'autoclose' => true,
                        'orientation' => "bottom"
                    ]
                ]);
                ?>
            </div>
            <div class="col-md-4" style="margin-bottom:15px">
                <?php
                echo '<label>Tanggal Berlaku <span style="color:red">*</span></label>';
                echo DatePicker::widget([
                    'model' => $model,
                    'readonly' => true,
                    'attribute' => 'tgl_exp1',
                    'options' => ['placeholder' => 'Pilih Tanggal ...', 'id' => 'tgl_berlaku'],
                    'pluginOptions' => [
                        'format' => 'yyyy-mm-dd',
                        'todayHighlight' => true,
                        'autoclose' => true,
                        'orientation' => "bottom"
                    ]
                ]);
                ?>
            </div>
            <div class="col-md-4" style="margin-bottom:15px">
                <?php
                echo '<label>Tanggal Expired <span style="color:red">*</span></label>';
                echo DatePicker::widget([
                    'model' => $model,
                    'readonly' => true,
                    'attribute' => 'tgl_exp2',
                    'options' => ['placeholder' => 'Pilih Tanggal ...', 'id' => 'tgl_expired'],
                    'pluginOptions' => [
                        'format' => 'yyyy-mm-dd',
                        'todayHighlight' => true,
                        'autoclose' => true,
                        'orientation' => "bottom"
                    ]
                ]);
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?= $form->field($model, 'informasi_sakit')->textarea(['rows' => '3', 'maxlength' => true, 'id' => 'informasi_sakit', 'placeholder' => 'Masukkan keterangan sakit, informasi tambahan dan lainnya.']) ?>
            </div>
        </div>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success', 'onclick' => 'return columnvalidation();']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>


</div>