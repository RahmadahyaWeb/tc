<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MsProvider */

$this->title = 'Input Provider';
$this->params['breadcrumbs'][] = ['label' => 'Master Provider', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ms-provider-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		'listJenisProvider' => $listJenisProvider,
    ]) ?>

</div>
