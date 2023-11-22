<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MsPeserta */

$this->title = 'Input Peserta';
$this->params['breadcrumbs'][] = ['label' => 'Master Peserta', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ms-peserta-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		'listDepartemen' => $listDepartemen,
		'listUnitbisnis' => $listUnitbisnis,
		'listLevel' => $listLevel
    ]) ?>

</div>
