<?php

$this->title = "DATA HAK KELAS & PLAFON KEPESERTAAN";

$no = 1;

?>

<div class="row justify-content-end my-3">
	<div class="col-6">
		<form action="<?= \yii\helpers\Url::to(['/kelas-plafon/index']) ?>" method="GET">
			<div class="row">
				<label class="col-sm-5 col-form-label fw-bold text-end">NO. ID PESERTA :</label>
				<div class="col-sm-7">
					<input type="text" name="kode_anggota" class="form-control rounded-0 mb-2" value="<?= (isset($_GET['kode_anggota']) ? $_GET['kode_anggota'] : '') ?>">
				</div>
				<div class="col-sm-5"></div>
				<div class="col-sm-7">
					<button type="submit" class="btn btn-dark rounded-0">Cari</button>
				</div>
			</div>
		</form>
	</div>
</div>

<?php if ($peserta) : ?>
	<div class="my-3">
		<p class="p-0 m-0">No. ID Peserta : <?= $peserta['kode_anggota'] ?></p>
		<p class="p-0 m-0">Nama Peserta : <?= $peserta['nama_peserta'] ?></p>
		<p class="p-0 m-0">Level Jabatan : <?= $peserta['level_jabatan'] ?></p>
	</div>

	<div class="my-3">
		Hak Kelas Peserta :
		<ul>
			<?php foreach ($hak_kelas as $data) : ?>
				<?php
						$hak_kelas_peserta = (new yii\db\Query())
							->select(["ms_plafonextend.nominal"])
							->from('ms_plafonextend')
							->where([
								'nama_plafon' => $data['nama_plafon'],
								'level' => $peserta['level_jabatan'],
								'jumlah_anggota' => $jumlah_anggota
							])
							->one();

						?>
				<li>
					<?php if ($data['nama_plafon'] == 'RAWAT JALAN' || $data['nama_plafon'] == 'RAWAT INAP') : ?>
						Biaya <?= ($data['nama_plafon'])  ?> = <?= "Rp " . number_format($hak_kelas_peserta['nominal'], 0, ',', '.') ?>
					<?php else : ?>
						Biaya <?= ($data['nama_plafon'])  ?> = <?= "Rp " . number_format($data['nominal'], 0, ',', '.') ?>
					<?php endif ?>
				</li>
			<?php endforeach ?>
		</ul>
	</div>

	<table class="table table-bordered text-center text-white">
		<thead class="table-dark">
			<tr>
				<th>NO</th>
				<th>JENIS PLAFON</th>
				<th>PEMAKAIAN PLAFON</th>
				<th>SISA PEMAKAIAN</th>
				<th>KET</th>
			</tr>
		</thead>
		<tbody class="transparan">
			<?php if (count($data_plafon) > 0) : ?>
				<?php foreach ($data_plafon as $data) : ?>
					<tr class="fw-bold">
						<td><?= $no++ ?></td>
						<td><?= $data["nama_plafon"] ?></td>
						<td><?= "Rp " . number_format($data['total_biaya'], 0, ',', '.') ?></td>
						<?php

									$sisa_pemakaian_plafon_extend = (new yii\db\Query())
										->select(["ms_plafonextend.nominal"])
										->from("ms_plafonextend")
										->where([
											"nama_plafon" 	=> $data["nama_plafon"],
											"level"		  	=> $peserta["level_jabatan"],
											"jumlah_anggota" => $jumlah_anggota
										])
										->one();

									$sisa_pemakaian_plafon = (new yii\db\Query())
										->select(["ms_plafon.nominal", "ms_plafon.nama_plafon"])
										->from("ms_plafon")
										->where([
											"nama_plafon" 	=> $data["nama_plafon"],
											"level"		  	=> $peserta["level_jabatan"],
										])
										->one();
									?>
						<td>
							<?php
										if ($data["nama_plafon"] === "RAWAT INAP" || $data["nama_plafon"] === "RAWAT JALAN") {
											$sisa_pemakaian = number_format($sisa_pemakaian_plafon_extend["nominal"] - $data["total_biaya"], 0, ',', '.');

											echo "Rp " .  $sisa_pemakaian;
										} else {
											echo "Rp " . number_format($sisa_pemakaian_plafon["nominal"] - $data["total_biaya"], 0, ',', '.');
										}
										?>
						</td>
						<td>
							<?php
										if (isset($sisa_pemakaian_plafon_extend['nominal'])) {
											$sisa_pemakaian = $sisa_pemakaian_plafon_extend['nominal'] - $data['total_biaya'];

											if ($sisa_pemakaian <= 0) {
												echo "PLAFON HABIS";
												echo "<script>
    													window.onload = function() {
        													alert('Peserta harap segera melapor ke Pengurus Tricare untuk proses lebih lanjut');
    													};
    												</script>";
											}
										} elseif (isset($sisa_pemakaian_plafon['nominal'])) {
											$sisa_pemakaian = $sisa_pemakaian_plafon['nominal'] - $data['total_biaya'];

											if ($sisa_pemakaian <= 0) {
												echo "PLAFON HABIS";
												echo "<script>
    													window.onload = function() {
        													alert('Peserta harap segera melapor ke Pengurus Tricare untuk proses lebih lanjut');
    													};
    												</script>";
											}
										}
										?>
						</td>
					</tr>
				<?php endforeach ?>
			<?php else : ?>
				<tr class="text-center">
					<td colspan="5">TIDAK ADA DATA</td>
				</tr>
			<?php endif; ?>
		</tbody>
	</table>

	<div class="row gap-3">
		<div class="col-12">
			<div>
				Noted :
			</div>
			<div>
				<ul>
					<li>
						Jika plafon rawat jalan dan rawat inap sudah habis akan muncul di kolom keterangan "PLAFON HABIS"
						dan muncul notifikasi "Peserta harap segera melapor ke Pengurus Tricare untuk proses lebih lanjut".
					</li>
				</ul>
			</div>
		</div>
	</div>

<?php else : ?>
	<table class="table table-bordered">
		<thead class="table-dark">
			<tr class="text-center">
				<th>NO</th>
				<th>JENIS PLAFON</th>
				<th>PEMAKAIAN PLAFON</th>
				<th>SISA PEMAKAIAN</th>
				<th>KET</th>
			</tr>
		</thead>
		<tbody class="transparan text-white">
			<tr class="text-center fw-bold">
				<td colspan="5">TIDAK ADA DATA</td>
			</tr>
		</tbody>
	</table>
<?php endif ?>