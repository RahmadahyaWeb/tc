<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MsNonbenefit */

$this->title = 'Input Value Master Non Benefit';
$this->params['breadcrumbs'][] = ['label' => 'Master Non Benefit', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ms-nonbenefit-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
