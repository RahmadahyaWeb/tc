<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TrProgressProvider */

$this->title = 'Update Progress Tricare Provider: ' . $model->resi;
$this->params['breadcrumbs'][] = ['label' => 'Progress Tricare Provider', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->resi, 'url' => ['view', 'id' => $model->resi]];
$this->params['breadcrumbs'][] = 'Update';

$tanggal_pembuatan_invoice = date("Y-m-d", strtotime($model->tanggal_pembuatan_invoice));
$tanggal_penerimaan_invoice = date("Y-m-d", strtotime($model->tanggal_penerimaan_invoice));
$tanggal_verifikasi_validasi_invoice = date("Y-m-d", strtotime($model->tanggal_verifikasi_validasi_invoice));
$tanggal_pembayaran_invoice = date("Y-m-d", strtotime($model->tanggal_penerimaan_invoice));

?>
<div class="tr-progress-provider-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'list_provider' => $list_provider,
        'tanggal_pembuatan_invoice' => $tanggal_pembuatan_invoice,
        'tanggal_penerimaan_invoice' => $tanggal_penerimaan_invoice,
        'tanggal_verifikasi_validasi_invoice' => $tanggal_verifikasi_validasi_invoice,
        'tanggal_pembayaran_invoice' => $tanggal_pembayaran_invoice
    ]) ?>

</div>