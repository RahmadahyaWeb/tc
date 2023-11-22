<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\common;
use kartik\number\NumberControl;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TrProgressSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Lacak Klaim Tricare';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tr-progress-search">

    <h3>Tabel Progress Klaim</h3>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'resi',
            [
				'attribute'=>'Peserta',
				'value'=>function($data){
                    return $data['peserta']['kode_anggota'].' - '.$data['peserta']['nama_peserta'];
                }
			],
            'tanggal',
            [
                'attribute' => 'biaya',
                'value' => function($data){
                    $content_length = 160 - ((strlen($data['biaya']) * 9) + (floor((strlen($data['biaya'])/3)-0.1)));
                    $dispOptions = ['style' => "width:fit-content;margin-left:-".$content_length."px;height:20px;border:solid 0px;background-color:transparent;box-shadow:none"];
                    $res = NumberControl::widget([
                        'name' => 'biaya',
                        'value' => $data['biaya'],
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
            'status',
            //'status_date',
            //'progress',
            //'progress_1',
            //'progress_2',
            //'progress_3',
            //'progress_4',
            //'id_trans',
            //'input_by',
            //'input_date',
            //'modif_by',
            //'modif_date',

            // ['class' => 'yii\grid\ActionColumn'],
            [
				'class' => 'yii\grid\ActionColumn',
				'header' => '',
				'contentOptions'=>[
					'style'=>'text-align:center'
				],
				'headerOptions'=>['style'=>'color:#007bff'],
				'template' => '{btnLihat}',
				'buttons' => [
					'btnLihat' => function($url, $model, $key){
						return Html::a('Detail',['trprogress/cekresi', 'TrProgressSearch' => ['resi'=>$key]],['class'=>'btn btn-primary btn-xs']);
					}
				]
			]
            
        ],
    ]); ?>

</div>