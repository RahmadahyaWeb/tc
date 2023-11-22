<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\MsPlafon;
use kartik\number\NumberControl;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Master Plafon';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="ms-plafon-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Input Plafon', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'nama_plafon',
            'level',
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
            'input_by',
            'input_date',
            //'modi_by',
            //'modi_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
