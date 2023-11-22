<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\number\NumberControl;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TrPlafonSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Rekap Pemakaian Plafon';
$this->params['breadcrumbs'][] = $this->title;
?>
<script type="text/javascript">

	function tahunChange(){
		var departemen = document.getElementById("departemen");
		var kuartal = document.getElementById("kuartal");
		var row = document.getElementById("tr2");
		var x = document.getElementById("page");
		kuartal.value = '';
		departemen.value = '';
		row.style.display = 'none';
		x.style.display = 'none'
	}
	
	function prepDropdown(){
		var departemen = document.getElementById("departemen");
		var strDep = departemen.options[departemen.selectedIndex].value;
		var kuartal = document.getElementById("kuartal");
		var row = document.getElementById("tr2");
		var x = document.getElementById("page");
		kuartal.value = '';
		if(strDep == ''){
			row.style.display = 'none';
			x.style.display = 'none'
		} else {
			row.style.display = '';
		}
	}
	
	function autoDropdown(){
		var departemen = document.getElementById("departemen");
		var strDep = departemen.options[departemen.selectedIndex].value;
		var kuartal = document.getElementById("kuartal");
		var strK = kuartal.options[kuartal.selectedIndex].value;
		var tahun = document.getElementById("tahun").value;
		var header = document.getElementById("header");
		var x = document.getElementById("page");
		if(strK != ''){
            $('#maintable tbody').empty();
			$.post('index.php?r=trplafon/gettrans',{
				departemen: strDep,
				kuartal: strK,
				tahun: tahun
			},function(data){
				for(var i = 0; i < data.dataRes.length; i++){
					$('#bodytable').append(data.dataRes[i].row);
				}
            })
			
			header.innerHTML = strDep+' - '+strK;
			x.style.display="block";
		} else {
			x.style.display="none";
		}
		
	}

</script>
<div class="tr-plafon-index">

    <h1><?= Html::encode($this->title) ?></h1>
	<br />
	<?php 
		echo '<table>';
		echo '<tr style="height:40px"><td>Pilih Tahun</td><td style="width:20px;text-align:center"> : </td><td>';
		echo Html::DropDownList('tahun','',$listTahun,[
			'class' => 'form-control',
			'style'=>'width:fit-content',
			'id' => 'tahun',
			'onchange' =>'tahunChange()',
		]);
		echo '</td></tr>';
		echo '<tr style="height:40px"><td>Pilih Departemen</td><td style="width:20px;text-align:center"> : </td><td>';
		echo Html::DropDownList('departemen','',$listDepartemen,[
			'prompt'=>'-- Pilih Departemen --',
			'class' => 'form-control',
			'style'=>'width:fit-content',
			'id' => 'departemen',
			'onchange' =>'prepDropdown()',
		]);
		echo '</td></tr>';
		echo '<tr id = "tr2" style="display:none"><td>Pilih Kuartal</td><td style="width:20px;text-align:center"> : </td><td>';
		echo Html::DropDownList('kuartal','',[
			'KUARTAL 1' => 'Kuartal 1',
			'KUARTAL 2' => 'Kuartal 2',
			'KUARTAL 3' => 'Kuartal 3',
			'KUARTAL 4' => 'Kuartal 4'
		],[
			'prompt'=>'-- Pilih Kuartal --',
			'class' => 'form-control',
			'style'=>'width:fit-content',
			'id' => 'kuartal', 
			'onchange' =>'autoDropdown()',
			'required' => 'required',
			'hidden' => true
		]);
		echo '</td></tr></table><br />';
		
	?>
	<br />
	<div id = 'page' style="display:none">
		<h2 id = 'header' style="text-align:center"></h2>
		<br />
		<table class="table table-bordered" id = "maintable">
			<thead>
				<tr>
					<?php
						foreach($arrayHeader as $da){
							echo '<th style="text-align:center">'.$da.'</th>';
						}
					?>
				</tr>
			</thead>
			<tbody id = "bodytable">
			</tbody>
		</table>
	</div>

</div>
