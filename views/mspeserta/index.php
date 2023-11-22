<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Master Peserta';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ms-peserta-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Input Peserta', ['create'], ['class' => 'btn btn-success']) ?>
        &nbsp
        <?= Html::a('Sinkron Peserta', ['sync'], ['class' => 'btn btn-info']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'kode_anggota',
            'nama_peserta',
            'keterangan',
            [
				'attribute' => 'jenis_kelamin',
				'value' => function ($model, $key, $index, $column) {
					return $model->jenis_kelamin == 'P' ? 'Perempuan' : 'Laki-Laki';
				},
				'format' => 'raw'
			],
			'tempat_lahir',
            'tgl_lahir',
            'level_jabatan',
			//'divisi',
            //'input_by',
            //'input_date',
            //'modi_by',
            //'modi_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
