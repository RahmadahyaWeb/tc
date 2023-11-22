<?php 

$this->title = 'DOWNLOAD';

$no = 1;

?>

<table class="table table-bordered">
	<thead class="table-dark">
		<tr class="text-center">
			<th>NO</th>
			<th>NAMA FILE</th>
			<th>KETERANGAN</th>
		</tr>
	</thead>
	<tbody class="transparan text-white">
		<?php foreach ($documents as $document): ?>
			<?php  
			$link = Yii::$app->request->baseUrl.'/../'.$document['link'];
			?>
			<tr class="text-center fw-bold">
				<td><?= $no++ ?></td>
				<td><?= $document["judul"] ?></td>
				<td>
					<?= '<a target = "popup-example" href="'.$link.'" onclick = "javascript:open(\'#\', \'popup-example\', \'height=\'+window.innerheight+\',width=\'+window.innerwidth+\'resizable=no\')" class="btn btn-light rounded-0">UNDUH</a>'; ?>
				</td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>