<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\number\NumberControl;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MsPlafonextendSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Master Plafon 2';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ms-plafonextend-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Input Plafon', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'nama_plafon',
            'level',
            'jumlah_anggota',
            [
				'attribute' => 'nominal',
				'value' => function($model, $key, $index, $column){
					$res = NumberControl::widget([
						'name' => 'nominal',
						'value' => $model->nominal,
						'disabled'=> true,
						'maskedInputOptions' => ['prefix' => 'Rp. '],
					]);
					return $res;
				},
				'headerOptions' => ['style' => 'width:150px'],
				'format' => 'raw'
			],
            'keterangan',
            //'input_by',
            //'input_date',
            //'modi_by',
            //'modi_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
