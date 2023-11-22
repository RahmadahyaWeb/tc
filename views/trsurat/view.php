<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\number\NumberControl;

/* @var $this yii\web\View */
/* @var $model app\models\TrPlafon */

$this->title = "Detail Data Surat";
$this->params['breadcrumbs'][] = ['label' => 'Manajemen Surat Online', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

//var_dump($model);exit();
?>
<div class="tr-surat-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Cetak', ['print', 'id' => $model->id], [
            'class' => 'btn btn-warning',
            'data' => [
                'confirm' => 'Yakin Cetak Surat? Pastikan Data Sudah Benar.',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'no_surat',
			'jenis_surat',
            'tgl_surat',
            'tgl_kuitansi',
            'tgl_terimaclaim',
            'tgl_exp1',
            'tgl_exp2',
			'tujuan_surat',
			'up_surat',
			'nama_pengurus',
			'jabatan',
			'alamat',
			'kode_anggota',
			'nama_peserta',
			'alamat_peserta',
			'informasi_sakit',
			'keterangan_reject',
			'nominal_reject',
            'input_by',
            'input_date',
            'modi_by',
            'modi_date',
        ],
    ]) ?>

	

</div>
