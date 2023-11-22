<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MsUnitBisnisSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Master Unit Bisnis';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ms-unit-bisnis-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Input Unit Bisnis', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'unit_bisnis',
            'alias',
            // 'input_by',
            // 'input_date',
            'modi_by',
            'modi_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
