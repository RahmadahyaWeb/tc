<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MsJenisplafon */

$this->title = 'Input Tujuan Surat';
$this->params['breadcrumbs'][] = ['label' => 'Master Tujuan Surat', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ms-tujuansurat-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
