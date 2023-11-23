<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MsNonbenefitSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Master Non Benefit';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ms-nonbenefit-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Input Value Master Non Benefit', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'value',
            'input_by',
            'input_date',
            'modi_by',
            'modi_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
