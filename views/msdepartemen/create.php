<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MsDepartemen */

$this->title = 'Input Departemen';
$this->params['breadcrumbs'][] = ['label' => 'Master Departemen', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ms-departemen-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
