<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\number\NumberControl;


$this->title = "Detail Data Over Plafon";
$this->params['breadcrumbs'][] = ['label' => 'Trans Plafon', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

?>
<div class="tr-plafon-over-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->user->identity->user_group == "admin") : ?>
        <p>
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        </p>
    <?php endif; ?>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                [
                    'attribute' => 'kode_anggota',
                    'value' => $model->peserta->kode_anggota,
                ],
                [
                    'attribute' => 'nama_peserta',
                    'value' => $model->peserta->nama_peserta,
                ],
                'nama_plafon',
                [
                    'attribute' => 'nama_provider',
                    'value' => $model->provider->jenis_provider . ' - ' . $model->provider->nama,
                ],
                'tanggal',
                'tanggal_selesai',
                [
                    'attribute' => 'biaya',
                    'value' => function ($model, $column) {
                        $res = NumberControl::widget([
                            'name' => 'biaya',
                            'value' => $model->biaya,
                            'disabled' => true,
                            'maskedInputOptions' => ['prefix' => 'Rp. '],
                            'displayOptions' => ['style' => 'width:fit-content'],
                        ]);
                        return $res;
                    },
                    'format' => 'raw'
                ],
                'status'
            ],
        ]) ?>
</div>