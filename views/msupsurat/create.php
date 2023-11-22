<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MsJenisplafon */

$this->title = 'Input UP Surat';
$this->params['breadcrumbs'][] = ['label' => 'Master UP Surat', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ms-upsurat-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
