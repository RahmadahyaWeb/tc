<?php

use yii\helpers\Html;

$this->title = 'DATA KEPESERTAAN';

$no = 1;

?>

<div class="row justify-content-end my-3">
	<div class="col-6">
		<form action="<?= \yii\helpers\Url::to(['/peserta-provider/index']) ?>" method="GET">
			<div class="row">
				<label class="col-sm-5 col-form-label fw-bold text-end">NO. ID PESERTA :</label>
				<div class="col-sm-7">
					<input type="text" name="kode_anggota" class="form-control rounded-0 mb-2" value="<?= (isset($_GET['kode_anggota']) ? $_GET['kode_anggota'] : '') ?>">
				</div>
				<div class="col-sm-5"></div>
				<div class="col-sm-7">
					<button type="submit" class="btn btn-dark rounded-0 fw-bold">CARI</button>
				</div>
			</div>
		</form>
	</div>
</div>


<?php if (count($peserta) > 0) : ?>

	<div class="my-3">
		<p class="p-0 m-0">No. ID Peserta : <?= $pesertaInduk['kode_anggota'] ?></p>
		<p class="p-0 m-0">Nama Peserta : <?= $pesertaInduk['nama_peserta'] ?></p>
		<p class="p-0 m-0">Level Jabatan : <?= $pesertaInduk['level_jabatan'] ?></p>
		<p class="p-0 m-0">Badan Usaha : <?= $pesertaInduk['unit_bisnis'] ?></p>
	</div>

	<table class="table table-bordered">
		<thead class="table-dark">
			<tr class="text-center">
				<th>NO</th>
				<th>NAMA PESERTA</th>
				<th>STATUS TANGGUNGAN</th>
				<th>KET</th>
			</tr>
		</thead>
		<tbody class="transparan text-white">
			<?php foreach ($peserta as $data) : ?>
				<tr class="text-center fw-bold">
					<td><?= $no++ ?></td>
					<td><?= $data['nama_peserta'] ?></td>
					<td><?= $data['keterangan'] ?></td>
					<td>
						<?= ($data['active'] == 1) ? 'AKTIF' : 'TIDAK AKTIF'  ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<div class="row gap-3">
		<div class="col-12 d-flex justify-content-end">
			<?= Html::a(
					'CETAK KARTU',
					['printkartu', 'kode_anggota' => $data['kode_anggota']],
					['type' => 'button', 'class' => 'btn btn-dark rounded-0 fw-bold']
				) ?>
		</div>
	</div>

<?php else : ?>
	<table class="table table-bordered">
		<thead class="table-dark">
			<tr class="text-center">
				<th>NAMA PESERTA</th>
				<th>STATUS TANGGUNGAN</th>
				<th>KET</th>
			</tr>
		</thead>
		<tbody class="transparan text-white">
			<tr class="text-center fw-bold">
				<td colspan="3">TIDAK ADA DATA</td>
			</tr>
		</tbody>
	</table>
<?php endif ?>

<div class="row gap-3">
	<div class="col-12">
		<div>
			Noted :
		</div>
		<div>
			<ul>
				<li>Aktif = Karyawan Masih Bekerja di Trio Motor</li>
				<li>Non Aktif = Karyawan Berhenti Bekerja di Trio Motor/Tidak Menjadi Tanggungan Peserta</li>
			</ul>
		</div>
	</div>
</div>