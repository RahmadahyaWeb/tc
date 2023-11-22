<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\MsPeserta */

$this->title = $model->kode_anggota;
$this->params['breadcrumbs'][] = ['label' => 'Master Peserta', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

?>
<div class="ms-peserta-view">

    <h1><?= Html::encode($this->title.' : '.$model->nama_peserta) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
		<?= ($model->keterangan == "PESERTA INDUK") ? Html::a('Cetak Kartu', ['printkartu', 'kode_anggota' => $model->kode_anggota], ['class' => 'btn btn-success','target'=>'_blank']) : "" ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            'kode_anggota',
            'nama_peserta',
            'keterangan',
            [
				'attribute' => 'jenis_kelamin',
				'value' => function ($model, $column) {
					return $model->jenis_kelamin == 'P' ? 'Perempuan' : 'Laki-Laki';
				},
				'format' => 'raw'
			],
            'tempat_lahir',
            'alamat',
            'tgl_lahir',
            'level_jabatan',
			'departemen',
			'unit_bisnis',
			[
				'attribute' => 'active',
				'value' => function ($model, $column) {
					return $model->active == '1' ? 'Aktif' : 'Non Aktif';
				},
				'format' => 'raw'
			],
            // 'input_by',
            // 'input_date',
            // 'modi_by',
            // 'modi_date',
        ],
    ]) ?>

</div>
