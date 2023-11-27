<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\number\NumberControl;


/* @var $this yii\web\View */
/* @var $model app\models\TrProgressProvider */

$this->title = $model->resi;
$this->params['breadcrumbs'][] = ['label' => 'Progress Tricare Provider', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tr-progress-provider-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->resi], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->resi], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'resi',
            [
                'attribute' => 'bukti_pembayaran',
                'value' => function ($model, $column) {
                    $res = ($model->bukti_pembayaran !== "") ? Html::a('Lihat File', \Yii::$app->request->BaseUrl . '/../' .       $model->bukti_pembayaran, ['target' => '_blank', 'class' => 'btn btn-success btn-xs']) : '<button class="btn btn-success btn-xs" disabled="disabled">Tidak ada file</button>';

                    return $res;
                },
                'format' => 'raw'
            ],
            [
                'attribute' => 'id_provider',
                'label' => 'Provider',
                'value' => $model->provider->nama
            ],
            'no_invoice',
            [
                'attribute' => 'nominal_tagihan',
                'value' => function($model, $column){
                    $content_length = 160 - ((strlen($model->nominal_tagihan) * 9) + (floor((strlen($model->nominal_tagihan)/3)-0.1)));
                    $dispOptions = ['style' => "width:fit-content;margin-left:-".$content_length."px;height:20px;border:solid 0px;background-color:transparent;box-shadow:none"];
                    $res = NumberControl::widget([
                        'name' => 'nominal_tagihan',
                        'value' => $model->nominal_tagihan,
                        'disabled'=> true,
                        'maskedInputOptions' => [
                            'prefix' => 'Rp. '
                        ],
                        'displayOptions' => $dispOptions
                    ]);
                    return $res;
                },
                'format' => 'raw'
            ],
            'tanggal_pembuatan_invoice',
            'tanggal_penerimaan_invoice',
            'tanggal_verifikasi_validasi_invoice',
            'tanggal_pembayaran_invoice',
        ],
    ]) ?>

</div>