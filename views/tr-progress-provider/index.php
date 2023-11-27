<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\number\NumberControl;


/* @var $this yii\web\View */
/* @var $searchModel app\models\TrProgressProviderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Progress Tricare Provider';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tr-progress-provider-index">

    <h1>Progress Tricare Provider</h1>

    <p>
        <?= Html::a('Penerimaan Berkas', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'resi',
            [
                'attribute' => 'provider.nama',
                'label' => 'Nama Provider'
            ],
            'no_invoice',
            [
                'attribute' => 'nominal_tagihan',
                'value' => function($data){
                    $content_length = 160 - ((strlen($data['nominal_tagihan']) * 9) + (floor((strlen($data['nominal_tagihan'])/3)-0.1)));
                    $dispOptions = ['style' => "width:fit-content;margin-left:-".$content_length."px;height:20px;border:solid 0px;background-color:transparent;box-shadow:none"];
                    $res = NumberControl::widget([
                        'name' => 'nominal_tagihan',
                        'value' => $data['nominal_tagihan'],
                        'disabled'=> true,
                        'maskedInputOptions' => [
                            'prefix' => ' Rp. '
                        ],
                        'displayOptions' => $dispOptions
                    ]);
                    return $res;
                },
                'format' => 'raw'
            ],
            'tanggal_pembuatan_invoice',
            //'tanggal_penerimaan_invoice',
            //'tanggal_verifikasi_validasi_invoice',
            //'tanggal_pembayaran_invoice',
            //'bukti_pembayaran',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
