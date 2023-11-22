<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\number\NumberControl;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TrPlafonSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Trans Plafon';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tr-plafon-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Input Trans', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'id_peserta',
            [
				'attribute'=>'kode_anggota',
				'value'=>'peserta.kode_anggota'
			],
			[
				'attribute'=>'nama_peserta',
				'value'=>'peserta.nama_peserta'
			],
			[
				'attribute'=>'nama_plafon',
				'format'=>'raw',
				'filter'=> Html::ActiveDropDownList($searchModel,'nama_plafon',$listPlafon,['prompt'=>'-- LIST ALL --','class' => 'form-control','style'=>'width:fit-content'])
			],
            'tanggal',
			'tanggal_selesai',
            [
				'attribute' => 'biaya',
				'value' => function($model, $key, $index, $column){
					$res = NumberControl::widget([
						'name' => 'biaya',
						'value' => $model->biaya,
						'disabled'=> true,
						'maskedInputOptions' => ['prefix' => 'Rp. '],
						'displayOptions' => ['style' => 'width:fit-content'],
					]);	
					return $res;
				},
				'format' => 'raw'
			],
            //'input_by',
            //'input_date',
            //'modi_by',
            //'modi_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
