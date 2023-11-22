<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\MsProvider */

$this->title = $model->jenis_provider.' - '.$model->nama;
$this->params['breadcrumbs'][] = ['label' => 'Master Provider', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="ms-provider-view">

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
            'jenis_provider',
            'id_provider',
            'nama',
            'kab_kota',
            'alamat',
            'no_telp',
            'web',
            'input_by',
            'input_date',
            'modi_by',
            'modi_date',
        ],
    ]) ?>

</div>
