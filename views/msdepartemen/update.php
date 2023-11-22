<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MsDepartemen */

$this->title = 'Update Departemen: ' . $model->departemen;
$this->params['breadcrumbs'][] = ['label' => 'Master Departemen', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->departemen, 'url' => ['view', 'id' => $model->departemen]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ms-departemen-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
