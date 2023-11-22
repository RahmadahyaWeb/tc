<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Master Draft Benefit';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ms-benefit-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Input Draft Benefit', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'judul',
            [
                'header' =>'Nama File',
				'attribute' => 'link',
				'value' => function ($model, $key, $index, $column) {
					$val = explode("/",$model->link);
                    return $val[2];
                    //return $model->jenis_kelamin == 'P' ? 'Perempuan' : 'Laki-Laki';
				},
				'format' => 'raw'
			],
            //'link',
            'create_by',
            'create_time',
            //'modif_by',
            //'modif_time',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
