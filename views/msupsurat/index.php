<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Master UP Surat';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ms-jenisplafon-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Input UP Surat', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'up',
            'input_by',
            'input_date',
            'modi_by',
            'modi_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
