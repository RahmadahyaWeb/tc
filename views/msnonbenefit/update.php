<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MsNonbenefit */

$this->title = 'Update Value Non Benefit: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Master Non Benefit', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ms-nonbenefit-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
