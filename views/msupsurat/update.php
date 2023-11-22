<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MsJenisplafon */

$this->title = 'Update UP Surat: ' . $model->up;
$this->params['breadcrumbs'][] = ['label' => 'Master UP Surat', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->up, 'url' => ['view', 'id' => $model->up]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ms-upsurat-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
