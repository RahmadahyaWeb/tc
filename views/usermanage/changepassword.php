<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User_manage */

$this->title = 'Change Password User: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'User Management', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-manage-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formcp', [
        'model' => $model,
    ]) ?>

</div>
