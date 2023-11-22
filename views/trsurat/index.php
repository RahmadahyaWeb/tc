<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\number\NumberControl;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TrSuratSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Manajemen Surat Online';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tr-surat-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Buat Surat', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'no_surat',
            'jenis_surat',
            'tgl_surat',
            'kode_anggota',
            'nama_peserta',
            'tujuan_surat',
            'up_surat',
            //'input_by',
            //'input_date',
            //'modi_by',
            //'modi_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
