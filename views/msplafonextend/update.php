<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MsPlafonextend */

$this->title = 'Update Plafon: ' . $model->nama_plafon.' - '.$model->level;
$this->params['breadcrumbs'][] = ['label' => 'Master Plafon 2', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nama_plafon.' - '.$model->level, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ms-plafonextend-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formupdate', [
        'model' => $model
    ]) ?>

</div>
