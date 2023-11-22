<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MsProviderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Master Provider';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ms-provider-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Input Provider', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'id_provider',
            [
				'attribute'=>'jenis_provider',
				'format'=>'raw',
				'filter'=> Html::ActiveDropDownList($searchModel,'jenis_provider',$listJenisProvider,['prompt'=>'-- LIST ALL --','class' => 'form-control','style'=>'width:fit-content'])
			],
            'nama',
            'kab_kota',
            'alamat',
            'no_telp',
            'web',
            //'input_by',
            //'input_date',
            //'modi_by',
            //'modi_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
