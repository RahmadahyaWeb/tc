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

	<?php // echo $this->render('_search', ['model' => $searchModel]); 
	?>

	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'columns' => [
			['class' => 'yii\grid\SerialColumn'],

			//'id',
			//'id_peserta',
			[
				'attribute' => 'kode_anggota',
				'value' => 'peserta.kode_anggota'
			],
			[
				'attribute' => 'nama_peserta',
				'value' => 'peserta.nama_peserta'
			],
			[
				'attribute' => 'nama_plafon',
				'format' => 'raw',
				'filter' => Html::ActiveDropDownList($searchModel, 'nama_plafon', $listPlafon, ['prompt' => '-- LIST ALL --', 'class' => 'form-control', 'style' => 'width:fit-content'])
			],
			'tanggal',
			'tanggal_selesai',
			[
				'attribute' => 'biaya',
				'value' => function ($model, $key, $index, $column) {
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
			//'input_by',
			//'input_date',
			//'modi_by',
			//'modi_date',

			[
				'header' => 'Actions',
				'class' => 'yii\grid\ActionColumn',
				'template' => '{view} {update} {delete}',
				'buttons' => [
					'view' => function ($url, $model) {
						return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['trplafon/view', 'id' => $model->id], [
							'title' => Yii::t('yii', 'View'),
						]);
					},
					'update' => function ($url, $model) {
						return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['trplafon/update', 'id' => $model->id], [
							'title' => Yii::t('yii', 'Update'),
						]);
					},
					'delete' => function ($url, $model) {
						return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['trplafon/delete', 'id' => $model->id, 'id_peserta' => $model->id_peserta, 'nama_plafon' => $model->nama_plafon, 'tanggal' => $model->tanggal], [
							'title' => Yii::t('yii', 'Delete'),
							'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
							'data-method' => 'post',
						]);
					},
				],
			],
		],
	]); ?>


</div>