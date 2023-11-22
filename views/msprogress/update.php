<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MsProgress */

$this->title = 'Update Ms Progress: ' . $model->progress;
$this->params['breadcrumbs'][] = ['label' => 'Ms Progresses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->progress, 'url' => ['view', 'id' => $model->progress]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ms-progress-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
