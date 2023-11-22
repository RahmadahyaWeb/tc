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
        let input1 = $('#tanggal_pembuatan_invoice');
        let input2 = $('#tanggal_penerimaan_invoice');
        let input3 = $('#tanggal_verifikasi_validasi_invoice');
        let input4 = $('#tanggal_pembayaran_invoice');
        let file   = $('#trprogressprovider-bukti_pembayaran');   

        if (input1.val().trim() !== '') {
            input2.prop('disabled', false);
            var minDate = input1.val();
            input2.attr("min", minDate);
        } else {
            input2.prop('disabled', true);
        }

        if (input2.val().trim() !== '') {
            input3.prop('disabled', false);
            var minDate = input2.val();
            input3.attr("min", minDate);
        } else {
            input3.prop('disabled', true);
        }

        if (input3.val().trim() !== '') {
            input4.prop('disabled', false);
            var minDate = input3.val();
            input4.attr("min", minDate);
        } else {
            input4.prop('disabled', true);
        }

        if (input4.prop('disabled') === true) {
            file.prop('disabled', true);
        } 

        var buktiPembayaranValue = "<?= $model->bukti_pembayaran ?>"; 
        
        if (buktiPembayaranValue) {
            file.prop('required', false)
        }

        input1.on('change', function() {
            var minDate = input1.val();
            input2.attr("min", minDate);

            // if (input2.val() < input1.val()) {
            //     input2.val(minDate)
            // }

            if (input1.val().trim() === '') {
                input2.prop('disabled', true);
            } else {
                input2.prop('disabled', false);
            }
        });

        input2.on('change', function() {
            var minDate = input2.val();
            input3.attr("min", minDate);

            // if (input3.val() < input2.val()) {
            //     input3.val(minDate)
            // }

            if (input2.val().trim() === '') {
                input3.prop('disabled', true);
            } else {
                input3.prop('disabled', false);
            }
        });

        input3.on('change', function() {
            var minDate = input3.val();
            input4.attr("min", minDate);

            // if (input4.val() < input3.val()) {
            //     input4.val(minDate)
            // }

            if (input3.val().trim() === '') {
                input4.prop('disabled', true);
            } else {
                input4.prop('disabled', false);
            }
        });

        input4.on('change', function() {
          if (input4.val().trim() === '') {
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