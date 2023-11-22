<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\number\NumberControl;

/* @var $this yii\web\View */
/* @var $model app\models\TrPlafon */

$this->title = "Detail Trans";
$this->params['breadcrumbs'][] = ['label' => 'Trans Plafon', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

//var_dump($model);exit();
?>
<div class="tr-plafon-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
            [
				'attribute'=> 'kode_anggota',
				'value'=>$model->peserta->kode_anggota,
			],
			[
				'attribute'=> 'nama_peserta',
				'value'=>$model->peserta->nama_peserta,
			],
			'nama_plafon',
			[
				'attribute'=> 'nama_provider',
				'value'=>$model->provider->jenis_provider.' - '.$model->provider->nama,
			],
            'tanggal',
			'tanggal_selesai',
            [
				'attribute' => 'biaya',
				'value' => function($model, $column){
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
			
            'input_by',
            'input_date',
            'modi_by',
            'modi_date',
        ],
    ]) ?>

	

</div>
