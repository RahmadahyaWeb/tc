<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MsLevel */

$this->title = 'Input Level';
$this->params['breadcrumbs'][] = ['label' => 'Master Level', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ms-level-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
