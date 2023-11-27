<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TrProgressProvider */

$this->title = 'Penerimaan Berkas';
$this->params['breadcrumbs'][] = ['label' => 'Progress Tricare Provider', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="tr-progress-provider-create">

  <h1>Penerimaan Berkas</h1>

  <?= $this->render('_form', [
    'model' => $model,
    'list_provider' => $list_provider
  ]) ?>





</div>