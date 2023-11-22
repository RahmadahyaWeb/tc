<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\number\NumberControl;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TrPlafonSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Iuran Bulanan';
$this->params['breadcrumbs'][] = $this->title;
?>
<script type="text/javascript">

	function prepDropdown(){
		var departemen = document.getElementById("unit_bisnis");
		var strDep = departemen.options[departemen.selectedIndex].value;
		var row = document.getElementById("tr2");
		var row2 = document.getElementById("tr3");
		var x = document.getElementById("page");
		//kuartal.value = '';
		
		if(strDep == ''){
			row.style.display = 'none';
			row2.style.display = 'none';
			x.style.display = 'none'
		} else {
			row.style.display = '';
			row2.style.display = '';
		}
	}
	
	function capitalize(s){
		return s.toLowerCase().replace( /\b./g, function(a){ return a.toUpperCase(); } );
	};
	
	function toMoney(s){
		return s.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	}
	
	function month_name(dt){
		dt = dt - 1;
		mlist = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember" ];
		return mlist[dt];
	}

	async function cetakpdf(){
		
		var tgl = document.getElementById("tanggal").value;
		var iuran = document.getElementById("tagihan_iuran").value;
		var x = document.getElementById("page");
		var unit_bisnis = document.getElementById("unit_bisnis");
		var strUB = unit_bisnis.options[unit_bisnis.selectedIndex].value;
		if(tgl == "" || iuran == ""){
			alert("Pilih Tanggal / Isi Nominal")
			x.style.display = "none";
			return false
		} else {
			$('#maintable tbody').empty();
			$.post('index.php?r=trplafon/getiuranbulananpeserta',{
				unit_bisnis: strUB,
				tanggal: tgl
			},function(data){
				var jmlAnggota = data.jmlPeserta;
				var iuranPeserta = data.iuran;
				var kota = data.kota;
				var membuat = data.membuat;
				var menyetujui = data.menyetujui;
				var mengetahui = data.mengetahui;
				for(var i = 0; i < data.dataRes.length; i++){
					$('#bodytable').append(data.dataRes[i].row);
				}
				
				dataPDF(jmlAnggota, strUB, tgl, iuran, iuranPeserta, kota, membuat, menyetujui, mengetahui)
            })
		}
	}
	
	function sleep(ms) {
		return new Promise(resolve => setTimeout(resolve, ms));
	}

	
	function terbilang(bilangan) {

		bilangan    = String(bilangan);
		var angka   = new Array('0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0');
		var kata    = new Array('','Satu','Dua','Tiga','Empat','Lima','Enam','Tujuh','Delapan','Sembilan');
		var tingkat = new Array('','Ribu','Juta','Milyar','Triliun');

		var panjang_bilangan = bilangan.length;

		/* pengujian panjang bilangan */
		if (panjang_bilangan > 15) {
			kaLimat = "Diluar Batas";
			return kaLimat;
		}

		/* mengambil angka-angka yang ada dalam bilangan, dimasukkan ke dalam array */
		for (i = 1; i <= panjang_bilangan; i++) {
			angka[i] = bilangan.substr(-(i),1);
		}

		i = 1;
		j = 0;
		kaLimat = "";
		while (i <= panjang_bilangan) {
			subkaLimat = "";
			kata1 = "";
			kata2 = "";
			kata3 = "";
			/* untuk Ratusan */
			if (angka[i+2] != "0") {
				if (angka[i+2] == "1") {
					kata1 = "Seratus";
				} else {
					kata1 = kata[angka[i+2]] + " Ratus";
				}
			}
			/* untuk Puluhan atau Belasan */
			if (angka[i+1] != "0") {
				if (angka[i+1] == "1") {
					if (angka[i] == "0") {
						kata2 = "Sepuluh";
					} else if (angka[i] == "1") {
						kata2 = "Sebelas";
					} else {
						kata2 = kata[angka[i]] + " Belas";
					}
				} else {
					kata2 = kata[angka[i+1]] + " Puluh";
				}
			}

			/* untuk Satuan */
			if (angka[i] != "0") {
				if (angka[i+1] != "1") {
					kata3 = kata[angka[i]];
				}
			}
			/* pengujian angka apakah tidak nol semua, lalu ditambahkan tingkat */
			if ((angka[i] != "0") || (angka[i+1] != "0") || (angka[i+2] != "0")) {
				subkaLimat = kata1+" "+kata2+" "+kata3+" "+tingkat[j]+" ";
			}

			/* gabungkan variabe sub kaLimat (untuk Satu blok 3 angka) ke variabel kaLimat */
			kaLimat = subkaLimat + kaLimat;
			i = i + 3;
			j = j + 1;

		}

		/* mengganti Satu Ribu jadi Seribu jika diperlukan */
		if ((angka[5] == "0") && (angka[6] == "0")) {
			kaLimat = kaLimat.replace("Satu Ribu","Seribu");
		}

		return kaLimat + "Rupiah";
	}
	
	function dataPDF(jmlAnggota, strUB, tgl, iuran, iuranPeserta, kota, membuat, menyetujui, mengetahui){
		
		var bulan = (tgl.substring(5, 7)).replace(/^0+/, '');
		var tahun = (tgl.substring(0, 4));
		
		(function(API){
			API.myText = function(txt, options, x, y) {
				options = options ||{};
				if( options.align == "center" ){
					var fontSize = this.internal.getFontSize();
					var pageWidth = this.internal.pageSize.width;
					txtWidth = this.getStringUnitWidth(txt)*fontSize/this.internal.scaleFactor;
					x = ( pageWidth - txtWidth ) / 2;
				}
				this.text(txt,x,y);
			}
		})(jsPDF.API);
		
		var doc = new jsPDF('p', 'pt', 'letter');
		var htmlstring = '';
		var tempVarToCheckPageHeight = 0;
		var pageHeight = 0;
		pageHeight = doc.internal.pageSize.height;
		specialElementHandlers = {
			// element with id of "bypass" - jQuery style selector  
			'#bypassme': function (element, renderer) {
				// true = "handled elsewhere, bypass text extraction"  
				return true
			}
		};
		margins = {
			top: 150,
			bottom: 60,
			left: 40,
			right: 40,
			width: 600
		};
		var y = 20;
		doc.setLineWidth(2);
		//doc.text(200, y = y + 30, "Lampiran 1 - Peserta Tricare "+strUB);
		doc.myText("Lampiran 2 - Peserta Tricare "+strUB,{align: "center"},0,35);
		doc.autoTable({
			html: '#maintable',
			startY: 70,
			theme: 'grid',
			styles: {
				minCellHeight: 30
			}
		})
		doc.save(strUB+"-"+tahun+"-"+bulan+"-lampiran2.pdf");
			
		var doc = new jsPDF('L', 'mm', [297, 210]);
		doc.setLineWidth(1);
		doc.rect(15, 20, 267, 150);
		doc.setDrawColor(0);    
		doc.setFillColor(0, 255, 0);    
		doc.rect(15.5, 152, 266, 5, 'F');
		
		doc.text("Lampiran 1 - "+strUB+" "+month_name(bulan)+" "+tahun, 15,17);
		
		doc.setFontType("bold");
		doc.setFontSize(12);
		doc.myText("TANDA TERIMA TAGIHAN TRICARE",{align: "center"},0,25);
		var textWidth = doc.getTextWidth(menyetujui);
		doc.line(37, 121, 37 + textWidth, 121);
		var textWidth = doc.getTextWidth(mengetahui);
		doc.line(127, 121, 128 + textWidth, 121);
		var textWidth = doc.getTextWidth(membuat);
		doc.line(217, 121, 217 + textWidth, 121);
		doc.text(menyetujui, 37,120);
		doc.text(mengetahui, 127,120);
		doc.text(membuat, 217,120);
		
		doc.setFontType('normal');
		doc.text("SUDAH TERIMA DARI", 17,40);
		doc.text("BANYAK UANG", 17,50);
		doc.text("UNTUK PEMBAYARAN", 17,60);
		doc.text(":", 65,40);
		doc.text(":", 65,50);
		doc.text(":", 65,60);
		doc.text("Menyetujui,", 37,100);
		doc.text("Mengetahui,", 127,100);
		doc.text("Membuat,", 217,100);
		doc.text("NB :", 17,135);
		doc.text(strUB, 90,40);
		doc.text("Jaminan Pemeliharaan Kesehatan Karyawan "+capitalize(strUB)+" Bulan "+month_name(bulan)+" "+tahun, 90,60);
		doc.text(jmlAnggota + " Peserta (x) Rp. "+toMoney(iuranPeserta)+" (=) Rp. "+toMoney(jmlAnggota * iuranPeserta), 90,67);
		var d = new Date();
		doc.text(kota+", "+d.getDate()+" "+month_name(d.getMonth()+1)+" "+d.getFullYear(), 217,93);
		
		doc.setFontType("italic");
		doc.text((terbilang(jmlAnggota * iuranPeserta)).trim(), 90,50);
		doc.text("* Total Tagihan Untuk Bulan "+month_name(bulan)+" "+tahun+" sebesar : ", 17,142);
		doc.text("Rp.", 217,142);
		doc.text(toMoney(jmlAnggota * iuranPeserta), 265, 142, 'right');
		doc.text("* Tagihan iuran yang dibayarkan karyawan : ", 17,149);
		doc.text("Rp.", 217,149);
		doc.text(toMoney(iuran), 265, 149, 'right');
		doc.setFontType("bolditalic");
		doc.text("* Tagihan iuran yang dibayarkan oleh perusahaan : ", 17,156);
		doc.text("Rp.", 217,156);
		var gt = (jmlAnggota * iuranPeserta)-iuran;
		if(gt >= 0){
			doc.text(toMoney(gt), 265, 156, 'right');
		} else {
			doc.text("-", 265, 156, 'right');
			doc.setFontType("italic");
			doc.text("(biaya titipan lebih besar dari biaya tagihan, selisih lebih Rp. " + toMoney(iuran-(jmlAnggota*iuranPeserta)) + ")",265,163,'right');
		}
		doc.save(strUB+"-"+tahun+"-"+bulan+"-lampiran1.pdf");
		
		$("#maintable").css("font-size", "14px")
		var x = document.getElementById("page");
		x.style.display = "none";
	}

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.6/jspdf.plugin.autotable.min.js"></script>
<style>
#maintable tr { 
    overflow: hidden;
}
</style>
<div class="tr-plafon-index">

    <h1><?= Html::encode($this->title) ?></h1>
	
	<?php 
		echo '<table><tr style="height:40px"><td>Pilih Unit Bisnis</td><td style="width:20px;text-align:center"> : </td><td>';
		echo Html::DropDownList('unit_bisnis','',$listUnitBisnis,[
			'prompt'=>'-- Pilih Unit Bisnis --',
			'class' => 'form-control',
			'style'=>'width:fit-content',
			'id' => 'unit_bisnis',
			'onchange' =>'prepDropdown()',
		]);
		echo '</td></tr><tr id = "tr2" style="display:none;"><td>Pilih Bulan</td><td style="width:20px;text-align:center"> : </td><td>';
		echo DatePicker::widget([
			'model'=>$model,
			'readonly'=>true,
			'attribute' => 'tanggal', 
			'options' => ['placeholder' => 'Pilih Bulan...','id'=>'tanggal'],
			'pluginOptions' => [
				'startView'=>'year',
				'minViewMode'=>'months',
				'autoclose' => true,
				'format' => 'yyyy-mm',			
			],
			// 'pluginEvents' =>[ "changeDate" => "function(e) { autoDropdown(e) }", ] 		
		]);
		echo '</td></tr><tr id = "tr3" style="display:none;height:40px;"><td>Input Nominal Tagihan</td><td style="width:20px;text-align:center"> : </td><td>';
		echo NumberControl::widget([
			'model' => $model,
			'attribute' => 'biaya',
			'options'=>['id' => 'tagihan_iuran'],
			'maskedInputOptions' => ['prefix' => 'Rp. '],
		]);
		echo'</td></tr></table><br />';
		
	?>
	<!--button class="btn btn-success" onclick="display()">Tampilkan</button-->
	<button class="btn btn-info" onclick ="cetakpdf()">Cetak</button>
	<div id = 'page' style="display:none">
		<table class="table table-bordered" id = "maintable" >
			<thead id = 'table-header'>
				<tr id = 'table-header-row'>
					<th style="text-align:center">NO.</th>
					<th style="text-align:center">KODE ANGGOTA</th>
					<th style="text-align:center">NAMA PESERTA</th>
					<th style="text-align:center">KETERANGAN</th>
				</tr>
			</thead>
			<tbody id = "bodytable">
			</tbody>
		</table>
		<br />
	</div>
</div>
