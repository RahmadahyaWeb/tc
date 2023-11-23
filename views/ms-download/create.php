<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MsDownload */

$this->title = 'Create Ms Download';
$this->params['breadcrumbs'][] = ['label' => 'Ms Downloads', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ms-download-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
