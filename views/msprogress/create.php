<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MsProgress */

$this->title = 'Create Ms Progress';
$this->params['breadcrumbs'][] = ['label' => 'Ms Progresses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ms-progress-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
