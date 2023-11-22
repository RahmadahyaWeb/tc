<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\MsPlafon;
use kartik\number\NumberControl;
/* @var $this yii\web\View */
/* @var $model app\models\MsPlafon */

$this->title = $model->nama_plafon.' - '.$model->level;
$this->params['breadcrumbs'][] = ['label' => 'Master Plafon', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="ms-plafon-view">

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
            //'id',
            'nama_plafon',
            'level',
            [
				'attribute' => 'nominal',
				'value' => function($model, $column){
					$res = NumberControl::widget([
						'name' => 'nominal',
						'value' => $model->nominal,
						'disabled'=> true,
						'maskedInputOptions' => ['prefix' => 'Rp. '],
						'displayOptions' => ['style' => 'width:fit-content'],
					]);
					return $res;
				},
				'format' => 'raw'
			],
            'keterangan',
            'input_by',
            'input_date',
            'modi_by',
            'modi_date',
        ],
    ]) ?>

</div>
