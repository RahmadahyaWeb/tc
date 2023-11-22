<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MsConfig */

$this->title = 'Update Config: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Master Config', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->name]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ms-config-update">

    <h1><?= Html::encode($this->title) ?></h1>

	<div class="ms-config-form">
		<?php $form = ActiveForm::begin(); ?>
		<div class="row">
			<div class="col-md-4">
				<?= $form->field($model, 'name')->textInput(['maxlength' => true, 'disabled' => true ]) ?>
			</div>
			<div class="col-md-4">
				<?= $form->field($model, 'value')->textInput(['maxlength' => true]) ?>
			</div>
			<div class="col-md-4">
				<?= $form->field($model, 'value2')->textInput(['maxlength' => true]) ?>
			</div>
		</div>
		<div class="form-group">
			<?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
		</div>

		<?php ActiveForm::end(); ?>

	</div>

</div>
