<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MsJenisplafon */

$this->title = 'Input Jenis Plafon';
$this->params['breadcrumbs'][] = ['label' => 'Master Jenis Plafon', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ms-jenisplafon-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
