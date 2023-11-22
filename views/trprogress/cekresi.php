<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Progress;
use kartik\number\NumberControl;

/* @var $this yii\web\View */
/* @var $model app\models\TrProgress */

$this->title = "Progress Pencairan Tricare";
$this->params['breadcrumbs'][] = ['label' => 'Lacak Klaim Tricare', 'url' => ['cekresi']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tr-progress-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <hr />
    <p>
    </p>
    <div class="row">
        <div class="col-md-3 col-sm-12">
            <div class="row">
                <div class="col-md-2 col-sm-1 col-xs-1">
                    <div class="progress" style="width:30px;height:400px;">
                        <div class="progress-bar progress-bar-striped progress-bar-success active" role="progressbar" 
                            style="margin-top:<?= 400 - ($model->progress * 100); ?>px; width: 30px;">
                            <?= ($model->progress * 25); ?>%
                        </div>
                    </div>
                </div>
                <div class="col-md-10 col-sm-11 col-xs-11">
                    <div style="margin-top:0px">
                        Klaim Telah Dicairkan<br />
                        (<?= $model->progress_4; ?>)
                    </div>
                    <div style="margin-top:55px">
                        Proses di Finance MD<br />
                        (<?= $model->progress_3; ?>)
                    </div>
                    <div style="margin-top:60px;">
                        Verifikasi & Validasi Tricare<br />
                        (<?= $model->progress_2; ?>)
                    </div>
                    <div style="margin-top:60px">
                        Diterima PIC Tricare<br />
                        (<?= $model->progress_1; ?>)
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9 col-sm-12">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'resi',
                    [
                        'attribute'=> 'Peserta',
                        'value'=>$model->peserta->kode_anggota." - ".$model->peserta->nama_peserta,
                    ],
                    'tanggal',
                    [
                        'attribute' => 'biaya',
                        'value' => function($model, $column){
                            $content_length = 160 - ((strlen($model->biaya) * 9) + (floor((strlen($model->biaya)/3)-0.1)));
                            $dispOptions = ['style' => "width:fit-content;margin-left:-".$content_length."px;height:20px;border:solid 0px;background-color:transparent;box-shadow:none"];
                            $res = NumberControl::widget([
                                'name' => 'biaya',
                                'value' => $model->biaya,
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
                    'status_date',
                    'ket_app'
                    // [
                    //     'attribute'=> 'progress',
                    //     'value'=> $model->progress0->status,
                    // ],
                    // 'id_trans',
                ],
            ]); ?>
        </div>
    </div>
</div>
