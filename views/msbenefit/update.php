<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MsBenefit */

$this->title = 'Update Draft Benefit: ' . $model->judul;
$this->params['breadcrumbs'][] = ['label' => 'Master Draft Benefit', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->judul, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ms-benefit-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
