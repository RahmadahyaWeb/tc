<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MsLevel */

$this->title = 'Update Level: ' . $model->level_jabatan;
$this->params['breadcrumbs'][] = ['label' => 'Master Level', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->level_jabatan, 'url' => ['view', 'id' => $model->level_jabatan]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ms-level-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
