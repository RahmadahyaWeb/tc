<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\MsBenefit */

$this->title = $model->judul;
$this->params['breadcrumbs'][] = ['label' => 'Master Draft Benefit', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="ms-benefit-view">

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
            'judul',
            [
                'attribute' => 'link',
                'value' => function($model, $column){
                    $res = Html::a('Lihat File', \Yii::$app->request->BaseUrl.'/../'.$model->link, ['target' => '_blank', 'class' => 'btn btn-success btn-xs']);
                    return $res;
                },
                'format' => 'raw'
            ],
            'create_by',
            'create_time',
            'modif_by',
            'modif_time',
        ],
    ]) ?>

</div>
