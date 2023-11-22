<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'Cetak Kartu - '.$kode_anggota;
$this->params['breadcrumbs'][] = $this->title;
$htmldata = "";
$jmldata = 0;
$jk = "";
// Menginisialisasi variabel untuk menyimpan data peserta
$peserta_induk = '';
$suami_istri = '';
$lainnya = '';
$level_jabatan = '';
foreach ($data as $da){
	$words = explode(" ", $da->level_jabatan);

	foreach ($words as &$word) {
		if (strlen($word) <= 3) {
			$word = strtoupper($word);
		} else {
			$word = ucfirst(strtolower($word));
		}
	}

	$level_jabatan = implode(" ", $words);

    $tgl_lhr = date("d-m-Y", strtotime($da->tgl_lahir));
    if($da->keterangan == "PESERTA INDUK"){
        if($da->jenis_kelamin == "L"){
            $jk = "ISTRI";
        } else {
            $jk = "SUAMI";
        }
        
        $peserta_induk .= '
        <div id="pesertainduk" align="center">
            <p style="font-weight:bold;font-size:18px;">'.strtoupper($da->nama_peserta).'</p>
            <div id ="bigdate">
                <p style="font-weight:bold;font-size:18px;color:red">'.$tgl_lhr.'</p>
            </div>
        </div>
        ';
    } elseif($da->keterangan == "ISTRI" || $da->keterangan == "SUAMI") {
        $suami_istri .= '
        <div id="suamiistri" align="center">
            <p style="font-weight:bold;font-size:12px;color:red">'.$da->keterangan.'</p>
            <p style="font-weight:bold;font-size:10px;">'.strtoupper($da->nama_peserta).'</p>
            <div id ="smalldate">
                <p style="font-weight:bold;font-size:10px;">'.$tgl_lhr.'</p>
            </div>
        </div>
        ';
    } else {
        $lainnya .= '
        <div id="'.str_replace(' ', '', $da->keterangan).'" align="center">
            <p style="font-weight:bold;font-size:12px;color:red">'.$da->keterangan.'</p>
            <p style="font-weight:bold;font-size:10px;">'.strtoupper($da->nama_peserta).'</p>
            <div id ="smalldate">
                <p style="font-weight:bold;font-size:10px;">'.$tgl_lhr.'</p>
            </div>
        </div>
        ';
    }
    $jmldata++;
}

// Menggabungkan semua data peserta sesuai urutan yang diinginkan
$htmldata = $peserta_induk . $suami_istri . $lainnya;

if($jmldata != 5){
	if($jmldata ==1){
		$htmldata .= '
		<div id="suamiistri">
			<p style="font-weight:bold;font-size:12px;color:red">'.$jk.'</p>
			<p style="font-weight:bold;font-size:12px;">-</p>
		</div>
		';
		$sisa = $jmldata + 2;
		for($i=$sisa;$i <= 5; $i++){
			$urutan = $i - 2;
			$htmldata .= '
			<div id="ANAK'.($i - 2).'">
				<p style="font-weight:bold;font-size:12px;color:red">ANAK '.($i - 2).'</p>
				<p style="font-weight:bold;font-size:12px;">-</p>
			</div>
			';
		}
	} else {
		$sisa = $jmldata + 1;
		for($i=$sisa;$i <= 5; $i++){
			$urutan = $i - 2;
			$htmldata .= '
			<div id="ANAK'.($i - 2).'" align="center">
				<p style="font-weight:bold;font-size:12px;color:red">ANAK '.($i - 2).'</p>
				<p style="font-weight:bold;font-size:12px;">-</p>
			</div>
			';
		}
	}
}

?>
<!--div class="ms-peserta-index"-->
<div id="kotak" style="background-color: purple; border-radius: 48px 0 0 48px;
		text-align: center; position: absolute; color: white;
		z-index: 2; right: 266px; top: 90px; padding: 4px 17px;">
	<p style="font-weight: bold; font-size: 13px; margin: 0;">Level <?= $level_jabatan ?></p>
</div>
<div>
	<script type="text/javascript">	
 		//window.print();
	</script>
	
	<div id = "bg">		
		<div id="id">			
			<img src="../TRICARE/images/front.jpg" />
			
			<?php echo $htmldata; ?>
			
			<div id ="nikbawah">
				<p style="font-weight:bold;font-size:12px;color:white;"><?php echo $kode_anggota ?></p>
			</div>
			
		</div>	
		<img id ="idback" src="../TRICARE/images/back.jpg" />
</div>


</div>
