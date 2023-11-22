<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TrProgressProviderSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tr-progress-provider-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'resi') ?>

    <?= $form->field($model, 'id_provider') ?>

    <?= $form->field($model, 'no_invoice') ?>

    <?= $form->field($model, 'nominal_tagihan') ?>

    <?= $form->field($model, 'tanggal_pembuatan_invoice') ?>

    <?php // echo $form->field($model, 'tanggal_penerimaan_invoice') ?>

    <?php // echo $form->field($model, 'tanggal_verifikasi_validasi_invoice') ?>

    <?php // echo $form->field($model, 'tanggal_pembayaran_invoice') ?>

    <?php // echo $form->field($model, 'bukti_pembayaran') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>