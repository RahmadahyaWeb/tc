<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\number\NumberControl;


$this->title = "Update Data Over Plafon";
$this->params['breadcrumbs'][] = ['label' => 'Trans Plafon Over', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$url =  \yii\helpers\Url::to(['trplafon-over/update', 'id' => $model->id]);
$urlRedirect = \yii\helpers\Url::to(['trplafon-over/update', 'id' => $model->id]);

?>
<div class="tr-plafon-over-update">
    <div id="preloader" style="display: none;">
        <div class="loader"></div>
    </div>

    <h1><?= Html::encode($this->title) ?></h1>

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Kode Anggota</th>
                <th>Nama Peserta</th>
                <th>Nama Plafon</th>
                <th>Nama Provider</th>
                <th>Tanggal Kunjungan</th>
                <th>Biaya</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($dataOver) > 0) :  ?>
                <?php foreach ($dataOver as $index => $data) : ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= $data['kode_anggota'] ?></td>
                        <td><?= $data['nama_peserta'] ?></td>
                        <td><?= $data['nama_plafon'] ?></td>
                        <td><?= $data['nama']; ?></td>
                        <td style="width: 150px"><?= $data['tanggal'] ?></td>
                        <td><?= NumberControl::widget([
                                'name' => 'biaya',
                                'value' => $data['biaya'],
                                'disabled' => true,
                                'maskedInputOptions' => ['prefix' => 'Rp. '],
                                'displayOptions' => ['style' => 'width:180px'],
                            ]); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="8">No Results found.</td>
                </tr>
            <?php endif; ?>

        </tbody>
    </table>

    <div style="margin-left: 0px; margin-bottom: 20px;" class="row">
        <div style="border: 1px solid black; padding-top: 10px; padding-bottom: 25px" class="col-md-6">
            <h3><u><b>RINCIAN DATA OVER PLAFON</b></u></h3>
            <table style="width: 100%; font-size: 15px;">
                <tr>
                    <td style="width: 75%;">Plafon <?= $model->nama_plafon; ?> Tahun <?= substr($model->tanggal, 0, 4); ?></td>
                    <td>: <?= 'Rp. ' . number_format($jatahPlafon, 0, ',', '.'); ?></td>
                </tr>
                <tr>
                    <td>Pemakaian Plafon <?= $model->nama_plafon; ?> Tahun <?= substr($model->tanggal, 0, 4); ?></td>
                    <td>: <?= 'Rp. ' . number_format($totalBiayaPlafon['total_biaya'], 0, ',', '.'); ?></td>
                </tr>
                <tr>
                    <td>Total Biaya Over Plafon <?= $model->nama_plafon; ?> Tahun <?= substr($model->tanggal, 0, 4); ?></td>
                    <td>: <?= 'Rp. ' . number_format($totalBiayaOver['total_biaya'], 0, ',', '.'); ?></td>
                </tr>
            </table>
        </div>
    </div>

    <?php if (Yii::$app->user->identity->user_group == 'admin') : ?>
        <?php $form = ActiveForm::begin(); ?>
        <div class="form-group">
            <label for="trplafonover-status" style="float: left; width: 10%;">Status Bayar</label>
            <div style="float: left; width: 20%;">
                <select id="trplafonover-status" class="form-control" name="TrPlafonOver[status]">
                    <option value="" selected>-- Pilih Data --</option>
                    <?php foreach ($listStatusBayar as $statusBayar) : ?>
                        <option value="<?= $statusBayar ?>" <?= ($statusBayar == $model->status) ? 'selected' : ''; ?>><?= $statusBayar ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div style="float: left; margin-left: 20px;">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success', 'id' => 'save-button']) ?>
            </div>
            <div style="clear:both;"></div>
            <div class="" style="float: left; width: 10%; color: transparent;">0</div>
            <div class="help-block-status text-danger" style="float: left; width: 20%;"></div>
        </div>
        <?php ActiveForm::end(); ?>
    <?php endif; ?>


</div>

<?php
$script =  <<< JS

$('#save-button').on('click', function(e) {
    e.preventDefault(); 

    if (validateForm()) {
        let formData = $('#w1').serialize();

        $('#preloader').show();

        function removePHPTags(url) {
            return url.replace(/<\?=\s*|\s*\?>/g, '');
        }

        let url = removePHPTags('<?= $url ?>');

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            success: function(response){
                let urlRedirect = removePHPTags('<?= $urlRedirect ?>')
                window.location.href = urlRedirect;                        
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    } else {
        validateForm();
    }

});

function validateForm(){
    let emptyInputs = true;

    if (!validateInput($('#trplafonover-status'), 'status bayar tidak boleh kosong', $('.help-block-status'))) {
        emptyInputs = false;
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

JS;
$this->registerJs($script);
?>