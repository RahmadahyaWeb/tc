<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\number\NumberControl;
use kartik\date\DatePicker;



/* @var $this yii\web\View */
/* @var $model app\models\TrProgressProvider */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tr-progress-provider-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-4">
            <?php
            echo $form->field($model, 'id_provider')->dropDownList(
                $list_provider,
                ['prompt' => '-- Pilih Provider --']
            )->label("Provider");
            ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'no_invoice')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-4">
            <?php
            echo '<label>Nominal Tagihan</label>';
            echo NumberControl::widget([
                'model' => $model,
                'attribute' => 'nominal_tagihan',
                'maskedInputOptions' => ['prefix' => 'Rp. '],
            ]);
            echo '<br />';
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <label>Tanggal Pembuatan Invoice</label>
                <input type="date" name="TrProgressProvider[tanggal_pembuatan_invoice]" id="tanggal_pembuatan_invoice" class="form-control" value="<?= $model->tanggal_pembuatan_invoice === null ? "" : $tanggal_pembuatan_invoice ?>">
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label>Tanggal Penerimaan Invoice</label>
                <input type="date" name="TrProgressProvider[tanggal_penerimaan_invoice]" id="tanggal_penerimaan_invoice" class="form-control" value="<?= $model->tanggal_penerimaan_invoice === null ? "" : $tanggal_penerimaan_invoice ?>">
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label>Tanggal Verifikasi & Validasi Invoice</label>
                <input type="date" name="TrProgressProvider[tanggal_verifikasi_validasi_invoice]" id="tanggal_verifikasi_validasi_invoice" class="form-control" value="<?= $model->tanggal_verifikasi_validasi_invoice === null ? "" : $tanggal_verifikasi_validasi_invoice ?>">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <label>Tanggal Pembayaran Invoice</label>
                <input type="date" name="TrProgressProvider[tanggal_pembayaran_invoice]" id="tanggal_pembayaran_invoice" class="form-control" value="<?= $model->tanggal_pembayaran_invoice === null ? "" : $tanggal_pembayaran_invoice ?>">
            </div>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'bukti_pembayaran')->fileInput() ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?php
    $script = <<< JS
    $(document).ready(function() {
        let tanggal_pembuatan_invoice = $('#tanggal_pembuatan_invoice');
        let tanggal_penerimaan_invoice = $('#tanggal_penerimaan_invoice');
        let tanggal_verifikasi_validasi_invoice = $('#tanggal_verifikasi_validasi_invoice');
        let tanggal_pembayaran_invoice = $('#tanggal_pembayaran_invoice');
        let file   = $('#trprogressprovider-bukti_pembayaran');   

        if (tanggal_pembuatan_invoice.val().trim() !== '') {
            tanggal_penerimaan_invoice.prop('disabled', false);
            var minDate = tanggal_pembuatan_invoice.val();
            tanggal_penerimaan_invoice.attr("min", minDate);
        } else {
            tanggal_penerimaan_invoice.prop('disabled', true);
        }

        if (tanggal_penerimaan_invoice.val().trim() !== '') {
            tanggal_verifikasi_validasi_invoice.prop('disabled', false);
            var minDate = tanggal_penerimaan_invoice.val();
            tanggal_verifikasi_validasi_invoice.attr("min", minDate);
        } else {
            tanggal_verifikasi_validasi_invoice.prop('disabled', true);
        }

        if (tanggal_pembayaran_invoice.prop('disabled') === true) {
            file.prop('disabled', true);
        } 

        var buktiPembayaranValue = "<?= $model->bukti_pembayaran ?>"; 
        
        if (buktiPembayaranValue) {
            file.prop('required', false)
        }

        tanggal_pembuatan_invoice.on('change', function() {
            var minDate = tanggal_pembuatan_invoice.val();
            tanggal_penerimaan_invoice.attr("min", minDate);

            if (tanggal_pembuatan_invoice.val().trim() === '') {
                tanggal_penerimaan_invoice.prop('disabled', true);
                tanggal_penerimaan_invoice.val(null);
                tanggal_verifikasi_validasi_invoice.val(null);
                tanggal_verifikasi_validasi_invoice.prop('disabled', true);
            } else {
                tanggal_penerimaan_invoice.prop('disabled', false);
                if (tanggal_verifikasi_validasi_invoice.val() !== '') {
                    if (tanggal_pembuatan_invoice.val() > tanggal_penerimaan_invoice.val()) {
                        tanggal_penerimaan_invoice.val(tanggal_pembuatan_invoice.val());
                        tanggal_verifikasi_validasi_invoice.val(tanggal_penerimaan_invoice.val());
                    }
                }
            }
        });

        tanggal_penerimaan_invoice.on('change', function() {
            var minDate = tanggal_penerimaan_invoice.val();
            tanggal_verifikasi_validasi_invoice.attr("min", minDate);

            if (tanggal_penerimaan_invoice.val().trim() === '') {
                tanggal_verifikasi_validasi_invoice.prop('disabled', true);
                tanggal_verifikasi_validasi_invoice.val(null);
            } else {
                tanggal_verifikasi_validasi_invoice.prop('disabled', false);
                if (tanggal_verifikasi_validasi_invoice.val() !== '') {
                    if (tanggal_penerimaan_invoice.val() > tanggal_verifikasi_validasi_invoice.val()) {
                        tanggal_verifikasi_validasi_invoice.val(tanggal_penerimaan_invoice.val());
                        tanggal_verifikasi_validasi_invoice.attr("min", minDate);
                    }
                }
            }
        });

        tanggal_pembayaran_invoice.on('change', function() {
          if (tanggal_pembayaran_invoice.val().trim() === '') {
            file.prop('disabled', true);
            file.removeAttr('required');
        } else {
            file.prop('disabled', false);
            file.attr('required', 'required');
        }
    });

    });
    JS;

    $this->registerJs($script);
    ?>

</div>