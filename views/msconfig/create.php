<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Input Config';
$this->params['breadcrumbs'][] = ['label' => 'Master Config', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ms-config-create">

    <h1><?= Html::encode($this->title) ?></h1>

	<div class="ms-config-form">

		<?php $form = ActiveForm::begin(); ?>
		<div class="row">
			<div class="col-md-4">
				<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
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
