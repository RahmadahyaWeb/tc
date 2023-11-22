<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\number\NumberControl;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\TrProgress */

$this->title = 'Penerimaan Berkas';
$this->params['breadcrumbs'][] = ['label' => 'Progress Tricare', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tr-progress-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="tr-progress-form">

        <?php $form = ActiveForm::begin(); ?>

        <div class="row">
			<div class="col-md-3">
                <?php 
                    echo $form->field($model, 'id_peserta')->dropDownList(
                        $listPeserta,
                        ['prompt'=>'-- Pilih Data --']
                    ); 
                ?>
            </div>
            <div class="col-md-3">
            <?php
                $model->tanggal = date('Y-m-d');
                echo '<label>Tanggal Kwitansi</label>';
                echo DatePicker::widget([
                    'model'=>$model,
                    'readonly'=>true,
                    'attribute' => 'tanggal', 
                    'options' => ['placeholder' => 'Pilih Tanggal ...'],
                    'pluginOptions' => [
                        'format' => 'yyyy-mm-dd',
                        'todayHighlight' => true,
                        'autoclose'=>true,
                    ]
                ]);       
            ?>
            </div>
            <div class="col-md-3">
            <?php
                echo '<label>Biaya</label>';
                echo NumberControl::widget([
                    'model' => $model,
                    'attribute' => 'biaya',
                    'maskedInputOptions' => ['prefix' => 'Rp. '],
                ]);
                echo '<br />';
            ?>
            </div>
			<div class="col-md-3">
            <?php
                $model->progress_1 = date('Y-m-d');
                echo '<label>Tgl. Terima</label>';
                echo DatePicker::widget([
                    'model'=>$model,
                    'readonly'=>true,
                    'attribute' => 'progress_1', 
                    'options' => ['placeholder' => 'Pilih Tanggal ...'],
                    'pluginOptions' => [
                        'format' => 'yyyy-mm-dd',
                        'todayHighlight' => true,
                        'autoclose'=>true,
                    ]
                ]);       
            ?>
            </div>
        </div>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
