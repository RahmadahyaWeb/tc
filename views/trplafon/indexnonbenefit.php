<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\number\NumberControl;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TrPlafonSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Rekap Data Nonbenefit';
$this->params['breadcrumbs'][] = $this->title;

// PAGINATION
$perPage = 10;
$totalData = $dataProvider->getTotalCount();
$currentPage = Yii::$app->request->get('page', 1);
$offset = ($currentPage - 1) * $perPage;
$models = $dataProvider->query->offset($offset)->limit($perPage)->all();
?>

<div class="tr-plafon">

	<h1><?= Html::encode($this->title) ?></h1>

	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>#</th>
				<th>Kode Anggota</th>
				<th>Nama Peserta</th>
				<th>Tanggal Berobat</th>
				<th>Biaya</th>
				<th>Keterangan Non Benefit</th>
				<th>Status</th>
				<th></th>
			</tr>
			<tr>
				<form action="<?= \yii\helpers\Url::to(['/trplafon/indexnonbenefit']) ?>" method="post">
					<input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken() ?>" />
					<th></th>
					<th>
						<input type="text" name="kode_anggota" class="form-control" value="<?= $searchModel->kode_anggota ? $searchModel->kode_anggota : '' ?>" onchange="this.form.submit()">
					</th>
					<th>
						<input type="text" name="nama_peserta" class="form-control" value="<?= $searchModel->nama_peserta ? $searchModel->nama_peserta : '' ?>" onchange="this.form.submit()">
					</th>
					<th></th>
					<th></th>
					<th></th>
					<th></th>
				</form>
			</tr>
		</thead>
		<tbody>
			<?php if (count($dataProvider->getModels()) > 0) :  ?>
				<?php foreach ($dataProvider->getModels() as $index => $model) : ?>
					<tr>
						<td><?= $index + 1 ?></td>
						<td><?= $model->peserta->kode_anggota ?></td>
						<td><?= $model->peserta->nama_peserta ?></td>
						<td style="width: 150px"><?= $model->tanggal ?></td>
						<td><?= NumberControl::widget([
								'name' => 'biaya',
								'value' => $model->biaya,
								'disabled' => true,
								'maskedInputOptions' => ['prefix' => 'Rp. '],
								'displayOptions' => ['style' => 'width:180px'],
							]); ?>
						</td>
						<td><?= $model->keterangan ?></td>
						<td style="width: 120px; text-transform: uppercase"><?= $model->status_bayar ?></td>
						<td style="width: 100px; text-align: center">
							<a href="<?= Url::to(['/trplafon/view-nonbenefit', 'id' => $model->id]) ?>">View Detail</a>
						</td>
					</tr>
				<?php endforeach; ?>
			<?php else : ?>
				<tr>
					<td colspan="8">No Results found.</td>
				</tr>	
			<?php endif; ?>
		</tbody>
	</table>

	<?php
	// Tampilkan tombol navigasi halaman
	echo \yii\widgets\LinkPager::widget([
		'pagination' => new \yii\data\Pagination([
			'totalCount' => $totalData,
			'pageSize' => $perPage,
			'defaultPageSize' => $perPage,
		]),
	]);
	?>

</div>