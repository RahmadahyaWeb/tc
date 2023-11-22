<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\MsPeserta;
use kartik\mpdf\Pdf;



class PesertaProviderController extends Controller
{
	public $layout = 'provider';

	public function actionIndex()
	{

		if (Yii::$app->user->isGuest) {
			return $this->redirect(array('/provider/login'));
		} elseif(Yii::$app->user->identity->id_provider == null){
			return $this->redirect(array('/provider/logout'));
		}

		$model = new MsPeserta();


		if (isset($_GET['kode_anggota'])) {
			$kode_anggota = $_GET['kode_anggota'];

			$model->load(Yii::$app->request->get());

			$pesertaInduk = $model->getPesertaInduk($kode_anggota);

			$peserta = (new \yii\db\Query())
			->select(['ms_peserta.nama_peserta', 'ms_peserta.keterangan', 'ms_peserta.active', 'ms_peserta.kode_anggota'])->distinct()
			->from('ms_peserta')
			->where(['ms_peserta.kode_anggota' => $kode_anggota])
			->all();
		} else {
			$peserta = [];
			$pesertaInduk = [];
		}


		return $this->render('index', [
			'peserta' => $peserta,
			'pesertaInduk' => $pesertaInduk
		]);
	}

	public function actionPrintkartu($kode_anggota)
	{

		$model = new MsPeserta();
		$data = $model->getPesertaAll($kode_anggota);

		$content = $this->renderPartial('../mspeserta/kartu', [
			'data' => $data,
			'kode_anggota' => $kode_anggota
		]);
		//
		$pdf = new Pdf([
			'mode' => Pdf::MODE_CORE,
			'format' => Pdf::FORMAT_A4,
			'filename' => 'Kartu Tricare - ' . $kode_anggota . '.pdf',
			//'orientation' => Pdf::ORIENT_LANDSCAPE, 
			'destination' => Pdf::DEST_BROWSER,
			// 'destination' => Pdf::DEST_DOWNLOAD, //DEST_BROWSER, DEST_FILE, DEST_STRING
			'content' => $content,
			'cssInline' => '

#id {
			width:470px;
			height:310px;
			position:absolute;
			border-radius:22px;
		}

#bigdate{
		float:left;
		margin-top:-15px;
	}
#smalldate{
	float:left;
	margin-top:-10px;
}

#pesertainduk {
width:470px;
height:90px;
margin-top:-230px;
position:absolute;
float:left;
font-family: arial;
text-align:center;
}

#suamiistri {
width:127px;
height:95px;
margin-top:34px;
position:absolute;
float:left;
text-align:center;
}
#ANAK1 {
width:118px;
height:95px;
position:absolute;
text-align:center;
float:left;
}
#ANAK2 {
width:120px;
height:95px;
position:absolute;
float:left;
text-align:center;
}
#ANAK3 {
width:105px;
height:95px;
position:absolute;
float:left;
text-align:center;
}

#nikbawah {
width:470px;
height:90px;
position:absolute;
float:left;
text-align:center;
margin-top:-9px;
}

#idback{
float:left;
position:absolute;
margin-top:-50px;
width:470px;
height:310px
text-align:center;
}',
'methods' => [
	'SetTitle' => ['Cetak Kartu Tricare'],
	'SetHeader' => ['Kartu Tricare'],
	'SetFooter' => ['{PAGENO}'],
]
]);
		return $pdf->render();
	}
}