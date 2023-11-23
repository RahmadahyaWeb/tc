<?php
$this->title = 'PROGRESS PEMBAYARAN TAGIHAN';

use yii\bootstrap\LinkPager;
use yii\helpers\Html;


$startNumber = $pagination->getPage() * $pagination->pageSize + 1;
?>

<!-- Search -->
<div class="row justify-content-end my-3">
	<div class="col-6">
		<form action="<?= \yii\helpers\Url::to(['/progress-provider/index']) ?>" method="GET">
			<div class="row">
				<label class="col-sm-5 col-form-label fw-bold text-end">NO. RESI :</label>
				<div class="col-sm-7">
					<input type="text" name="resi" class="form-control rounded-0 mb-2" value="<?= (isset($_GET['resi']) ? $_GET['resi'] : '') ?>">
				</div>
				<div class="col-sm-5"></div>
				<div class="col-sm-7">
					<button type="submit" class="btn btn-dark rounded-0">Cari</button>
				</div>
			</div>
		</form>
	</div>
</div>

<?php if (count($results) > 0) : ?>

	<!-- Table -->
	<div class="row">
		<div class="col">
			<table class="table table-bordered" id="example">
				<thead class="table-dark">
					<tr class="text-center">
						<th>NO</th>
						<th>NO. RESI</th>
						<th>NAMA PROVIDER</th>
						<th>JUMLAH TAGIHAN</th>
						<th>STATUS</th>
						<th></th>
					</tr>
				</thead>
				<tbody class="transparan text-white">
					<?php foreach ($results as $index => $data) : ?>
						<tr class="text-center">
							<td><?= $startNumber + $index ?></td>
							<td><?= $data['resi'] ?></td>
							<td><?= $data['nama'] ?></td>
							<td>
								<?= "Rp " . number_format($data['nominal_tagihan'], 0, ',', '.') ?>
							</td>
							<td>
								<?= $data['tanggal_pembayaran_invoice'] === null ? 'BELUM BAYAR' : 'SUDAH BAYAR' ?>
							</td>
							<td class="text-center">
								<form action="<?= \yii\helpers\Url::to(['/progress-provider/index']) ?>" method="GET">
									<input type="hidden" name="resi" value="<?= $data['resi'] ?>">
									<button type="submit" class="btn btn-dark">
										<i class="fa-solid fa-eye"></i>
									</button>
								</form>
							</td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		</div>
	</div>

	<!-- Pagination -->
	<div class="row">
		<div class="col d-flex justify-content-end">
			<?= LinkPager::widget([
				'pagination' => $pagination,
				'prevPageLabel' => 'Previous',
				'nextPageLabel' => 'Next',
				'firstPageLabel' => false,
				'lastPageLabel' => false,
				'maxButtonCount' => 3,
			]); ?>
		</div>
	</div>

	<!-- Detail Progress Pembayaran -->
	<?php if (isset($_GET['resi'])) : ?>
		<?php
		// Ambil data detail progress berdasarkan resi
		$resi = $_GET['resi'];
		$query = (new \yii\db\Query())
		->select(["*"])
		->from("tr_progress_provider")
		->join("INNER JOIN", "ms_provider", "ms_provider.id = tr_progress_provider.id_provider")
		->where([
			"tr_progress_provider.id_provider" => $id_provider,
			"tr_progress_provider.resi"		   => $resi
		])
		->groupBy("tr_progress_provider.id_provider")
		->orderBy("tr_progress_provider.tanggal_pembuatan_invoice")
		->one();
		?>

		<div class="row my-4 py-3 transparan">
			<div class="col-sm-5">
				<h5 class="py-2">PROGRESS PEMBAYARAN TAGIHAN :</h5>
				<hr>
				<div class="ui relaxed divided list">
					<div class="item">
						<div class="content">
							<div class="description">
								Tanggal Pembayaran Invoice <br>
								<?php if ($query['tanggal_pembayaran_invoice'] != null) : ?>
									(<?= 
										date('d-M-Y', strtotime($query['tanggal_pembayaran_invoice']));
									?>)
								<?php endif; ?>
							</div>
							<?php 
							$warna = ($query['tanggal_pembayaran_invoice'] != null) ? 'green' : 'white';
							$style = "position: absolute; top: 50%; left: 8px; width: 30px; height: 30px; margin-top: -15px; border-radius: 100%; background: $warna; z-index: 1;"; 
							?>
							<div style="<?= $style ?>"></div>
						</div>
					</div>
					<div class="item">
						<div class="content">
							<div class="description">
								Tanggal Verifikasi & Validasi Invoice <br>
								<?php if ($query['tanggal_verifikasi_validasi_invoice'] != null) : ?>
									(<?= 
										date('d-M-Y', strtotime($query['tanggal_verifikasi_validasi_invoice'])); 
									?>)
								<?php endif; ?>
							</div>
							<?php 
							$warna = ($query['tanggal_verifikasi_validasi_invoice'] != null) ? 'green' : 'white';
							$style = "position: absolute; top: 50%; left: 8px; width: 30px; height: 30px; margin-top: -15px; border-radius: 100%; background: $warna; z-index: 1;"; 
							?>
							<div style="<?= $style ?>"></div>
						</div>
					</div>
					<div class="item">
						<div class="content">
							<div class="description">
								Tanggal Penerimaan Invoice <br>
								(<?= date('d-M-Y', strtotime($query['tanggal_penerimaan_invoice'])); ?>)
							</div>
							<div style="position: absolute; top: 50%; left: 8px; width: 30px; height: 30px; margin-top: -15px; border-radius: 100%; background: green; z-index: 1;"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-7">
				<h5 class="py-2">DETAIL PROGRESS PEMBAYARAN TAGIHAN :</h5>
				<hr>
				<table style="width: 100%">
					<tr>
						<td class="text-end" style="width: 45%">No. Resi</td>
						<td>:</td>
						<td>
							<input type="text" class="form-control rounded-0" disabled value="<?= $query['resi'] ?>">
						</td>
					</tr>
					<tr>
						<td class="text-end" style="width: 45%">Provider</td>
						<td>:</td>
						<td>
							<input type="text" class="form-control rounded-0" disabled value="<?= $query['nama'] ?>">
						</td>
					</tr>
					<tr>
						<td class="text-end" style="width: 45%">No. Invoice</td>
						<td>:</td>
						<td>
							<input type="text" class="form-control rounded-0" disabled value="<?= $query['no_invoice'] ?>">
						</td>
					</tr>
					<tr>
						<td class="text-end" style="width: 45%">Nominal Tagihan</td>
						<td>:</td>
						<td>
							<input type="text" class="form-control rounded-0" disabled value="<?= "Rp " . number_format($query['nominal_tagihan'], 0, ',', '.') ?>">
						</td>
					</tr>
					<tr>
						<td class="text-end" style="width: 45%">Tanggal Pembuatan Invoice</td>
						<td>:</td>
						<td>
							<input type="text" class="form-control rounded-0" disabled value="<?= date_format(new DateTime($query['tanggal_pembayaran_invoice']), "d-F-Y") ?>">
						</td>
					</tr>
					<tr>
						<td class="text-end" style="width: 45%">Tanggal Penerimaan Invoice</td>
						<td>:</td>
						<td>
							<input type="text" class="form-control rounded-0" disabled value="<?= date_format(new DateTime($query['tanggal_penerimaan_invoice']), "d-F-Y") ?>">
						</td>
					</tr>
					<tr>
						<td class="text-end" style="width: 45%">Tanggal Verifikasi & Validasi Invoice</td>
						<td>:</td>
						<td>
							<input type="text" class="form-control rounded-0" disabled value="<?= ($query['tanggal_verifikasi_validasi_invoice'] != null) ? date('d-F-Y', strtotime($query['tanggal_verifikasi_validasi_invoice'])) : '-' ?>">
						</td>
					</tr>
					<tr>
						<td class="text-end" style="width: 45%">Tanggal Pembayaran Invoice</td>
						<td>:</td>
						<td>
							<input type="text" class="form-control rounded-0" disabled value="<?= ($query['tanggal_pembayaran_invoice'] != null) ? date('d-F-Y', strtotime($query['tanggal_pembayaran_invoice'])) : '-' ?>">
						</td>
					</tr>
					<tr>
						<td class="text-end" style="width: 45%">Lampiran (Bukti Bayar)</td>
						<td>:</td>
						<td>
							<input type="text" class="form-control rounded-0" disabled value="<?= ($query['bukti_pembayaran'] == null) ? "-" : basename($query['bukti_pembayaran']) ?>">
						</td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td>
							<?php 
							$link = Yii::$app->request->baseUrl.'/../'.$query['bukti_pembayaran'];
							?>
							<?= ($query['bukti_pembayaran'] == null) ? '<button class="btn btn-dark btn-sm rounded-0" disabled>Tidak ada file</button>' : '<a target = "popup-example" href="'.$link.'" onclick = "javascript:open(\'#\', \'popup-example\', \'height=\'+window.innerheight+\',width=\'+window.innerwidth+\'resizable=no\')" class="btn btn-dark btn-sm rounded-0">Download</a>'; ?>
						</td>
					</tr>
				</table>
			</div>
		</div>
	<?php endif ?>

<?php else : ?>
	<div class="row">
		<div class="col">
			<table class="table table-bordered text-center text-white" id="example">
				<thead class="table-dark">
					<tr>
						<th>NO</th>
						<th>NO. RESI</th>
						<th>NAMA PROVIDER</th>
						<th>JUMLAH TAGIHAN</th>
						<th>STATUS</th>
						<th></th>
					</tr>
				</thead>
				<tbody class="transparan">
					<tr class="text-center">
						<td colspan="6">TIDAK ADA DATA</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<?php endif; ?>