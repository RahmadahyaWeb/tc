<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MsBenefit */

$this->title = 'Input Draft Benefit';
$this->params['breadcrumbs'][] = ['label' => 'Master Draft Benefit', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ms-benefit-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
