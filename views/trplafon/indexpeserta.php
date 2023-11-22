<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\number\NumberControl;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TrPlafonSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Trans Plafon';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tr-plafon-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'id_peserta',
            [
				'attribute'=>'kode_anggota',
				'value'=>'peserta.kode_anggota',
				'headerOptions'=>['style'=>'width:180px']
			],
			[
				'attribute'=>'nama_peserta',
				'value'=>'peserta.nama_peserta'
			],
			[
				'attribute'=>'nama_plafon',
				'format'=>'raw',
				'filter'=> Html::ActiveDropDownList($searchModel,'nama_plafon',$listPlafon,['prompt'=>'-- LIST ALL --','class' => 'form-control','style'=>'width:fit-content'])
			],
			[
				'attribute'=>'nama_provider',
				'value'=>'provider.nama'
			],
			[
				'attribute'=>'tanggal',
				'format'=>'raw',
				'filter'=> Html::ActiveDropDownList($searchModel,'tanggal',$listTahun,['prompt'=>'-- Tahun --','class' => 'form-control','style'=>'width:fit-content'])
			],
            [
				'attribute' => 'biaya',
				'value' => function($model, $key, $index, $column){
					$res = NumberControl::widget([
						'name' => 'biaya',
						'value' => $model->biaya,
						'disabled'=> true,
						'maskedInputOptions' => ['prefix' => 'Rp. '],
						'displayOptions' => ['style' => 'width:180px'],
					]);	
					return $res;
				},
				'format' => 'raw'
			],
            //'input_by',
            //'input_date',
            //'modi_by',
            //'modi_date',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
	
	<p style ="color:red">*Isi Nama plafon dan Tahun pada tanggal untuk melihat sisa plafon.</p>
	<?php
		if($showdiv){
			
			echo '<div style="border : solid black 2px; padding : 10px">
				<h3><u><b>Plafon Peserta Induk</b></u></h3>
				<table>';
			if(Html::like_match('%pembedahan%',$searchModel->nama_plafon) || Html::like_match('%kecelakaan%',$searchModel->nama_plafon)){
				echo '<tr>
					<td>
						<h3>Total Plafon '. $searchModel->nama_plafon.' Per-Transaksi </h3>
					</td>
					<td width="20px" style="text-align:center"><h3>:</h3></td>
					<td>
						<div style="width:150px">'.
						NumberControl::widget([
							'name' => 'nominal',
							'value' => $totalPlafon,
							'disabled'=> true,
							'maskedInputOptions' => ['prefix' => 'Rp. ','width'=>'300px'],
						])
						.'</div>
					</td>
				</tr>';
				echo '<tr>
					<td>
						<h3>Pemakaian Plafon '. $searchModel->nama_plafon.' '. $searchModel->tanggal.' </h3>
					</td>
					<td width="20px" style="text-align:center"><h3>:</h3></td>
					<td>
						<div style="width:150px">'.
						NumberControl::widget([
							'name' => 'nominal',
							'value' => $pemakaianPlafon,
							'disabled'=> true,
							'maskedInputOptions' => ['prefix' => 'Rp. ','width'=>'300px'],
						])
						.'</div>
					</td>
				</tr>';
			} else {
				echo '<tr>
					<td>
						<h3>Total Plafon ';
						echo $searchModel->nama_plafon.' '.$searchModel->tanggal.' </h3>
					</td>
					<td width="20px" style="text-align:center"><h3>:</h3></td>
					<td>
						<div style="width:150px">'.
						NumberControl::widget([
							'name' => 'nominal',
							'value' => $totalPlafon,
							'disabled'=> true,
							'maskedInputOptions' => ['prefix' => 'Rp. ','width'=>'300px'],
						])
						.'</div>
					</td>
				</tr>
				<tr>
					<td>
						<h3>Pemakaian Plafon ';
						echo $searchModel->nama_plafon.' ';
						if ($searchModel->nama_plafon == "KACAMATA"){
							echo $searchModel->tanggal - 1 .' - ';
						}
						echo $searchModel->tanggal.' </h3>
					</td>
					<td width="20px" style="text-align:center"><h3>:</h3></td>
					<td>
						<div style="width:150px">'.
						NumberControl::widget([
							'name' => 'nominal',
							'value' => $pemakaianPlafon,
							'disabled'=> true,
							'maskedInputOptions' => ['prefix' => 'Rp. ','width'=>'300px'],
						])
						.'</div>
					</td>
				</tr>
				<tr>
					<td>
						<h3>Sisa Plafon ';
						echo $searchModel->nama_plafon.' '.$searchModel->tanggal.' </h3>
					</td>
					<td width="20px" style="text-align:center"><h3>:</h3></td>
					<td>
						<div style="width:150px">'.
						NumberControl::widget([
							'name' => 'nominal',
							'value' => $sisaPlafon,
							'disabled'=> true,
							'maskedInputOptions' => ['prefix' => 'Rp. ','width'=>'300px'],
						])
						.'</div>
					</td>
				</tr>';
			}
			
			echo '</table></div>';
		}
		if($showdivA){
			echo '<br />';
			echo '<div style="border : solid black 2px; padding : 10px">
					<h3><u><b>Plafon Anggota Keluarga</b></u></h3>
					<table>';
				
			if(Html::like_match('%pembedahan%',$searchModel->nama_plafon) || Html::like_match('%kecelakaan%',$searchModel->nama_plafon)){
				echo '<tr>
						<td>
							<h3>Total Plafon '.$searchModel->nama_plafon.' Per-Transaksi </h3>
						</td>
						<td width="20px" style="text-align:center"><h3>:</h3></td>
						<td>
							<div style="width:150px">'.
							NumberControl::widget([
								'name' => 'nominal',
								'value' => $totalPlafonA,
								'disabled'=> true,
								'maskedInputOptions' => ['prefix' => 'Rp. ','width'=>'300px'],
							])
							.'</div>
						</td>
					</tr>';
				echo '<tr>
						<td>
							<h3>Pemakaian Plafon '.$searchModel->nama_plafon.' '.$searchModel->tanggal.' </h3>
						</td>
						<td width="20px" style="text-align:center"><h3>:</h3></td>
						<td>
							<div style="width:150px">'.
							NumberControl::widget([
								'name' => 'nominal',
								'value' => $pemakaianPlafonA,
								'disabled'=> true,
								'maskedInputOptions' => ['prefix' => 'Rp. ','width'=>'300px'],
							])
							.'</div>
						</td>
					</tr>';
			} else {

				
					echo '<tr>
						<td>
							<h3>Total Plafon '.$searchModel->nama_plafon.' '.$searchModel->tanggal.' </h3>
						</td>
						<td width="20px" style="text-align:center"><h3>:</h3></td>
						<td>
							<div style="width:150px">'.
							NumberControl::widget([
								'name' => 'nominal',
								'value' => $totalPlafonA,
								'disabled'=> true,
								'maskedInputOptions' => ['prefix' => 'Rp. ','width'=>'300px'],
							])
							.'</div>
						</td>
					</tr>
					<tr>
						<td>
							<h3>Pemakaian Plafon '.$searchModel->nama_plafon.' '.$searchModel->tanggal.' </h3>
						</td>
						<td width="20px" style="text-align:center"><h3>:</h3></td>
						<td>
							<div style="width:150px">'.
							NumberControl::widget([
								'name' => 'nominal',
								'value' => $pemakaianPlafonA,
								'disabled'=> true,
								'maskedInputOptions' => ['prefix' => 'Rp. ','width'=>'300px'],
							])
							.'</div>
						</td>
					</tr>
					<tr>
						<td>
							<h3>Sisa Plafon '.$searchModel->nama_plafon.' '.$searchModel->tanggal.' </h3>
						</td>
						<td width="20px" style="text-align:center"><h3>:</h3></td>
						<td>
							<div style="width:150px">'.
							NumberControl::widget([
								'name' => 'nominal',
								'value' => $sisaPlafonA,
								'disabled'=> true,
								'maskedInputOptions' => ['prefix' => 'Rp. ','width'=>'300px'],
							])
							.'</div>
						</td>
					</tr>';
			}
			echo'</table></div>';
		}
	?>


</div>
