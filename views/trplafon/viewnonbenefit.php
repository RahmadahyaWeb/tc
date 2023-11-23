<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\number\NumberControl;

/* @var $this yii\web\View */
/* @var $model app\models\TrPlafon */

$this->title = "View Detail Data Non Benefit Tricare";
$this->params['breadcrumbs'][] = ['label' => 'Data Non Benefit Tricare', 'url' => ['indexnonbenefit']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

//var_dump($model);exit();
?>
<div class="tr-plafon-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->user->identity->user_group == "admin") : ?>
        <p>
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->id, 'id_peserta' => $model->id_peserta, 'nama_plafon' => $model->nama_plafon, 'tanggal' => $model->tanggal], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </p>
    <?php endif; ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'kode_anggota',
                'value' => $model->peserta->kode_anggota,
            ],
            'peserta.unit_bisnis',
            [
                'attribute' => 'nama_peserta',
                'value' => $model->peserta->nama_peserta,
            ],
            'nama_plafon',
            [
                'attribute' => 'nama_provider',
                'value' => $model->provider->jenis_provider . ' - ' . $model->provider->nama,
            ],
            'tanggal',
            'tanggal_selesai',
            [
                'attribute' => 'biaya',
                'value' => function ($model, $column) {
                    $res = NumberControl::widget([
                        'name' => 'biaya',
                        'value' => $model->biaya,
                        'disabled' => true,
                        'maskedInputOptions' => ['prefix' => 'Rp. '],
                        'displayOptions' => ['style' => 'width:fit-content'],
                    ]);
                    return $res;
                },
                'format' => 'raw'
            ],
            [
                'attribute' => 'keluhan',
                'label' => 'Informasi Medis / Keluhan'
            ],
            'keluhan',
            'invoice',
            'no_surat',
            [
                'attribute' => 'tgl_invoice',
                'label' => 'Tanggal Pengajuan Invoice'
            ],
            'status'
        ],
    ]) ?>


</div>