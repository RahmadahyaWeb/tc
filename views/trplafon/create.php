<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\number\NumberControl;
use kartik\select2\Select2;
use yii\jui\DatePicker as YiiDatePicker;
use yii\web\View;

$this->title = 'Input Trans';
$this->params['breadcrumbs'][] = ['label' => 'Trans Plafon', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$url =  \yii\helpers\Url::to(['trplafon/create']);
$urlCreateOver = \yii\helpers\Url::to(['trplafon/create-over']);
$urlRedirect = \yii\helpers\Url::to(['trplafon/view']);

?>

<div class="tr-plafon-create">
    <div id="preloader" style="display: none;">
        <div class="loader"></div>
    </div>

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="tr-plafon-form">
        <?php $form = ActiveForm::begin(); ?>

        <div class="row">
            <div class="col-md-4">
                <?= $form->field($model, 'id_peserta')->widget(Select2::classname(), [
                    'data' => $listPeserta,
                    'options' => ['placeholder' => '-- Pilih Data --'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->error(['class' => 'help-block-id_peserta text-danger']); ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'nama_plafon')->widget(Select2::classname(), [
                    'data' => $listJenisPlafon,
                    'options' => ['placeholder' => '-- Pilih Data --'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->error(['class' => 'help-block-nama_plafon text-danger']); ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'id_provider')->widget(Select2::classname(), [
                    'data' => $listProvider,
                    'options' => ['placeholder' => '-- Pilih Data --'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->error(['class' => 'help-block-id_provider text-danger']); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="trplafon-status_benefit">Status Benefit</label>
                    <select id="trplafon-status_benefit" class="form-control">
                        <option value="">-- Pilih Data --</option>
                        <?php foreach ($listStatusPlafon as $statusPlafon) : ?>
                            <option value="<?= $statusPlafon ?>"><?= $statusPlafon ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="help-block-status_benefit text-danger"></div>
                </div>
            </div>
            <div class="col-sm-4">
                <?php
                echo $form->field($model, 'tanggal')->input('date', ['class' => 'form-control'])->error(['class' => 'help-block-tanggal text-danger']);;
                ?>
            </div>
            <div class="col-sm-4">
                <?php
                echo $form->field($model, 'tanggal_selesai')->input('date', ['class' => 'form-control'])->error(['class' => 'help-block-tanggal_selesai text-danger']);;
                ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <?php
                echo '<label>Biaya</label>';
                echo NumberControl::widget([
                    'model' => $model,
                    'attribute' => 'biaya',
                    'maskedInputOptions' => ['prefix' => 'Rp. '],
                ]);
                echo '<div class="help-block-biaya text-danger"></div>';
                echo '<br />';
                ?>
            </div>
        </div>

        <div id="nonbenefit_form" style="display: none">
            <hr style="border-top: 2px solid black">
            <div class="row">
                <div class="col-md-4" style="display: none;">
                    <?= $form->field($model, 'nonbenefit')->textInput(['id' => 'nonbenefit', 'readonly' => true])->label('Non Benefit') ?>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <?php
                        echo $form->field($model, 'keluhan')->input('text', ['class' => 'form-control'])->error(['class' => 'help-block-keluhan text-danger'])->label('Informasi Medis / Keluhan');
                        ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <?php
                        echo $form->field($model, 'tindakan')->input('text', ['class' => 'form-control'])->error(['class' => 'help-block-tindakan text-danger']);
                        ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <?php
                    echo $form->field($model, 'keterangan')->dropDownList(
                        ['' => '-- Pilih Data --'] + $listKeterangan,
                        ['id' => 'trplafon-keterangan', 'class' => 'form-control']
                    )->error(['class' => 'help-block-keterangan text-danger'])->label('Keterangan Non Benefit'); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <?php
                    echo $form->field($model, 'invoice')->dropDownList(
                        ['' => '-- Pilih Data --'] + $listProvider,
                        ['id' => 'trplafon-invoice', 'class' => 'form-control']
                    )->error(['class' => 'help-block-invoice text-danger'])->label('Invoice'); ?>
                </div>
                <div class="col-md-4">
                    <?php
                    echo $form->field($model, 'no_surat')->input('text', ['class' => 'form-control'])->error(['class' => 'help-block-no_surat text-danger']);;
                    ?>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <?php
                        echo $form->field($model, 'tgl_invoice')->input('date', ['class' => 'form-control'])->error(['class' => 'help-block-tgl_invoice text-danger'])->label('Tanggal Pengajuan Invoice');
                        ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <?php
                    echo $form->field($model, 'status_bayar')->dropDownList(
                        ['' => '-- Pilih Data --'] + $listStatusBayar,
                        ['id' => 'trplafon-status_bayar', 'class' => 'form-control']
                    )->error(['class' => 'help-block-status_bayar text-danger'])->label('Status Bayar'); ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success', 'id' => 'save-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

</div>


<?php
$script = <<< JS
$(document).ready(function () {

let status = $('#trplafon-status_benefit');
let nonbenefitInput = $('#nonbenefit');
let nonbenefitForm = $('#nonbenefit_form');
let inputIdPeserta = $('#trplafon-id_peserta');
let inputNamaPlafon = $('#trplafon-nama_plafon');
let inputIdProvider = $('#trplafon-id_provider');
let inputStatusBenefit = $('#trplafon-status_benefit');
let inputKeluhan = $('#keluhan');
let inputTindakan = $('#tindakan');
let inputKeterangan = $('#trplafon-keterangan');
let inputInvoice = $('#trplafon-invoice');
let inputNoSurat = $('#trplafon-no_surat');
let inputStatusBayar = $('#trplafon-status_bayar');

function toggleNonbenefitFormVisibility() {

    if (status.val() === 'Ya') {
        nonbenefitForm.hide();
        nonbenefitInput.val('');
        inputKeluhan.val('');
        inputTindakan.val('');
        inputKeterangan.val('');
        inputInvoice.val('');
        inputNoSurat.val('');
        inputStatusBayar.val('');

    } else if (status.val() === '') {
        nonbenefitForm.hide();
        nonbenefitInput.val('');
        inputKeluhan.val('');
        inputTindakan.val('');
        inputKeterangan.val('');
        inputInvoice.val('');
        inputNoSurat.val('');
        inputStatusBayar.val('');

    } else {
        nonbenefitInput.val('*');
        nonbenefitForm.show();
    }

}

toggleNonbenefitFormVisibility();
status.on('change', toggleNonbenefitFormVisibility);

$('#trplafon-tanggal').on('change', function () {
    $('#trplafon-tanggal_selesai').attr('min', $('#trplafon-tanggal').val());

    if ($('#trplafon-tanggal').val().trim() !== '') {
        $('#trplafon-tanggal_selesai').prop('disabled', false);
    } else {
        $('#trplafon-tanggal_selesai').prop('disabled', true);
        $('#trplafon-tanggal_selesai').val('');
    }

    if ($('#trplafon-tanggal_selesai').val().trim() !== '') {
        if ($('#trplafon-tanggal_selesai').val() < $('#trplafon-tanggal').val()) {
            $('#trplafon-tanggal_selesai').val($('#trplafon-tanggal').val());
        }
    }
});



});

function validateForm() {
    let inputIdPeserta = $('#trplafon-id_peserta');
    let inputNamaPlafon = $('#trplafon-nama_plafon');
    let inputIdProvider = $('#trplafon-id_provider');
    let inputStatusBenefit = $('#trplafon-status_benefit');
    let inputBiaya = $('#trplafon-biaya-disp');
    let helpBlockBiaya = $('.help-block-biaya');
    let inputKeluhan = $('#trplafon-keluhan');
    let inputTindakan = $('#trplafon-tindakan');
    let inputKeterangan = $('#trplafon-keterangan');
    let inputInvoice = $('#trplafon-invoice');
    let inputNoSurat = $('#trplafon-no_surat');
    let inputStatusBayar = $('#trplafon-status_bayar');
    let inputTanggal = $('#trplafon-tanggal');
    let inputTanggalSelesai = $('#trplafon-tanggal_selesai');
    let inputTanggalInvoice = $('#trplafon-tgl_invoice');

    let emptyInputs = true;

    if (inputStatusBenefit.val() === 'Ya' || inputStatusBenefit.val() === '') {
        if (!validateInput(inputIdPeserta, 'id peserta tidak boleh kosong', $('.help-block-id_peserta'))) {
            emptyInputs = false;
        }

        if (!validateInput(inputNamaPlafon, 'nama plafon tidak boleh kosong', $('.help-block-nama_plafon'))) {
            emptyInputs = false;
        }

        if (!validateInput(inputIdProvider, 'id provider tidak boleh kosong', $('.help-block-id_provider'))) {
            emptyInputs = false;
        }

        if (!validateInput(inputTanggal, 'tanggal mulai tidak boleh kosong', $('.help-block-tanggal'))) {
            emptyInputs = false;
        }

        if (!validateInput(inputTanggalSelesai, 'tanggal selesai tidak boleh kosong', $('.help-block-tanggal_selesai'))) {
            emptyInputs = false;
        }

        if (!validateInput(inputStatusBenefit, 'status benefit tidak boleh kosong', $('.help-block-status_benefit'))) {
            emptyInputs = false;
        }

        if (!validateInput(inputBiaya, 'biaya tidak boleh kosong', helpBlockBiaya)) {
            emptyInputs = false;
        }
    } else {
        if (!validateInput(inputIdPeserta, 'id peserta tidak boleh kosong', $('.help-block-id_peserta'))) {
            emptyInputs = false;
        }

        if (!validateInput(inputNamaPlafon, 'nama plafon tidak boleh kosong', $('.help-block-nama_plafon'))) {
            emptyInputs = false;
        }

        if (!validateInput(inputIdProvider, 'id provider tidak boleh kosong', $('.help-block-id_provider'))) {
            emptyInputs = false;
        }

        if (!validateInput(inputStatusBenefit, 'status benefit tidak boleh kosong', $('.help-block-status_benefit'))) {
            emptyInputs = false;
        }

        if (!validateInput(inputBiaya, 'biaya tidak boleh kosong', helpBlockBiaya)) {
            emptyInputs = false;
        }

        // TAMBAHAN VALIDASI JIKA STATUS BENEFIT = 'TIDAK'

        if (!validateInput(inputKeluhan, 'keluhan tidak boleh kosong', $('.help-block-keluhan'))) {
            emptyInputs = false;
        }

        if (!validateInput(inputTindakan, 'keluhan tidak boleh kosong', $('.help-block-tindakan'))) {
            emptyInputs = false;
        }

        if (!validateInput(inputKeterangan, 'keterangan tidak boleh kosong', $('.help-block-keterangan'))) {
            emptyInputs = false;
        }

        if (!validateInput(inputInvoice, 'invoice tidak boleh kosong', $('.help-block-invoice'))) {
            emptyInputs = false;
        }

        if (!validateInput(inputNoSurat, 'no surat tidak boleh kosong', $('.help-block-no_surat'))) {
            emptyInputs = false;
        }

        if (!validateInput(inputStatusBayar, 'status bayar tidak boleh kosong', $('.help-block-status_bayar'))) {
            emptyInputs = false;
        }

        if (!validateInput(inputTanggalInvoice, 'tanggal invoice tidak boleh kosong', $('.help-block-tgl_invoice'))) {
            emptyInputs = false;
        }

        if (!validateInput(inputTanggal, 'tanggal mulai tidak boleh kosong', $('.help-block-tanggal'))) {
            emptyInputs = false;
        }

        if (!validateInput(inputTanggalSelesai, 'tanggal selesai tidak boleh kosong', $('.help-block-tanggal_selesai'))) {
            emptyInputs = false;
        }

    }

    return emptyInputs;
}

function validateInput(input, errorMessage, helpBlock) {
    let cleanInput = input.val().replace(/^Rp\.\s*/, '');
    if (cleanInput.trim() === '') {
        helpBlock.html(errorMessage);
        return false;
    } else {
        helpBlock.html('');
        return true;
    }
}

$('#save-button').on('click', function(e) {
    e.preventDefault();

    if (validateForm()) {
        let formData = $('#w0').serialize();

        $('#preloader').show();
        
        function removePHPTags(url) {
            return url.replace(/<\?=\s*|\s*\?>/g, '');
        }

        let url = removePHPTags('<?= $url ?>');

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            success: function(response) {
                let responseData = JSON.parse(response);
                let namaPlafon = responseData.data.TrPlafon.nama_plafon;
                let success = responseData.success;
                let urlRedirect = removePHPTags('<?= $urlRedirect ?>')

                if (namaPlafon == "KACAMATA") {
                    if (success) {
                        window.location.href = urlRedirect + '&id=' + responseData.id;                        
                    }
                } else {
                    if (!success) {
                        let confirmed = confirm('Biaya melebihi sisa plafon. Lanjutkan proses?');
                        $('#preloader').hide();

                        if (confirmed) {
                            let urlCreateOver = removePHPTags('<?= $urlCreateOver ?>')
                            $('#preloader').show();
                            $.ajax({
                                url: urlCreateOver,
                                type: 'POST',
                                data: formData,
                                success: function(response){
                                    let responseData = JSON.parse(response);
                                    window.location.href = urlRedirect + '&id=' + responseData.id;
                                },
                                error: function(xhr, status, error){
                                    $('#preloader').hide();
                                    console.log(error);
                                }
                            });
                        }
                    } else {
                        window.location.href = urlRedirect + '&id=' + responseData.id;
                    }
                }
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
        
    } else {
        validateForm();
    }

});

JS;
$this->registerJs($script);
?>