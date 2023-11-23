<?php

namespace app\controllers;

use Yii;
use app\models\TrPlafon;
use app\models\TrPlafonSearch;
use app\models\TrPlafonSearchPeserta;
use app\models\MsPeserta;
use app\models\MsProvider;
use app\models\MsPlafon;
use app\models\MsPlafonextend;
use app\models\MsDepartemen;
use app\models\MsJenisPlafon;
use app\models\MsUnitbisnis;
use app\models\MsConfig;
use app\models\MsNonbenefit;
use app\models\TrPlafonOver;
use app\models\TrPlafonOverDetail;
use app\models\TrPlafonOverSearch;
use app\models\TrPlafonSearchPesertaNonbenefit;
use PHPUnit\Util\Log\JSON;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * TrplafonController implements the CRUD actions for TrPlafon model.
 */
class TrplafonController extends Controller
{
	public function checkuser()
	{
		if (Yii::$app->user->identity->user_group != 'admin') {
			return $this->goHome();
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function behaviors()
	{
		return [
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'delete' => ['POST'],
				],
			],
		];
	}

	/**
	 * Lists all TrPlafon models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$this->checkuser();
		$searchModel = new TrPlafonSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		$dataPlafon = MsJenisPlafon::find()
			->select(['nama_plafon'])
			->orderBy('nama_plafon')
			->all();
		$listPlafon = ArrayHelper::map($dataPlafon, 'nama_plafon', 'nama_plafon');
		//var_dump($searchModel);exit();
		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
			'listPlafon' => $listPlafon,
		]);
	}

	public function actionIndexpeserta()
	{
		if (!isset(Yii::$app->user->identity->username)) {
			return $this->redirect(['/site/login']);
		}
		$modelPlafonExtend = new MsPlafonextend();
		$searchModel = new TrPlafonSearchPeserta();
		$searchModel->kode_anggota = Yii::$app->user->identity->username;
		$searchModel->tanggal = date("Y");
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$sisaPlafon  = 0;
		$pemakaianPlafon = 0;
		$totalPlafon = 0;
		$showdiv = false;
		$sisaPlafonA  = 0;
		$pemakaianPlafonA = 0;
		$totalPlafonA = 0;
		$showdivA = false;

		$dataPlafon = MsJenisPlafon::find()
			->select(['nama_plafon'])
			->orderBy('nama_plafon')
			->all();
		$listPlafon = ArrayHelper::map($dataPlafon, 'nama_plafon', 'nama_plafon');

		$dataTahun = TrPlafon::find()
			->select(['LEFT(tanggal,4) as tanggal'])
			->orderBy('tanggal desc')
			->groupBy(['LEFT(tanggal,4)'])
			->all();
		//var_dump($dataTahun);exit();
		$listTahun = ArrayHelper::map($dataTahun, 'tanggal', 'tanggal');

		if ($searchModel->nama_plafon != "" and $searchModel->tanggal != "") {
			$modelPeserta = new MsPeserta();
			$plafonModel = new MsPlafon();

			$dataPeserta = $modelPeserta->find()
				->where("kode_anggota = '" . $searchModel->kode_anggota . "'")
				->andWhere("keterangan='PESERTA INDUK'")
				->andWhere("active=1")
				->one();
			$level_jabatan = $dataPeserta->level_jabatan;

			if ($searchModel->nama_plafon == "KECELAKAAN" || Html::like_match('%PEMBEDAHAN%', $searchModel->nama_plafon)) {
				$data = $plafonModel->find()
					->where("nama_plafon = '" . $searchModel->nama_plafon . "'")
					->andWhere("level = '" . $level_jabatan . "'")
					->One();
				$dataAnggota = $modelPlafonExtend->find()
					->where("nama_plafon = '" . $searchModel->nama_plafon . "'")
					->One();
				if (isset($dataAnggota)) {
					$searchModel->nama_plafon = $dataAnggota->nama_plafon;
					$totalPlafon = $data->nominal;
					$totalPlafonA = $dataAnggota->nominal;
					$dataTr = $dataProvider->getModels();
					foreach ($dataTr as $da) {
						$checkPeserta = $modelPeserta->find()->select(["keterangan"])->where("id = " . $da->id_peserta)->one();
						if ($checkPeserta->keterangan == "PESERTA INDUK") {
							$pemakaianPlafon = $pemakaianPlafon + $da->biaya;
						} else {
							$pemakaianPlafonA = $pemakaianPlafonA + $da->biaya;
						}
					}
					$sisaPlafon = $totalPlafon - $pemakaianPlafon;
					$sisaPlafonA = $totalPlafonA - $pemakaianPlafonA;
					$showdiv = true;
					$showdivA = true;
				}
			} else {
				if ($searchModel->nama_plafon == "RAWAT JALAN" || $searchModel->nama_plafon == "RAWAT INAP") {
					$anggota = $modelPeserta->find()
						->select(["count(kode_anggota) as kode_anggota"])
						->where("kode_anggota = '" . $searchModel->kode_anggota . "'")
						->andWhere("active=1")
						->one();
					$jmlAnggota = $anggota->kode_anggota;

					$data = $modelPlafonExtend->find()
						->where("nama_plafon = '" . $searchModel->nama_plafon . "'")
						->andWhere("level = '" . $level_jabatan . "'")
						->andWhere("jumlah_anggota = '" . $jmlAnggota . "'")
						->One();
				} else {
					$data = $plafonModel->find()
						->where("nama_plafon = '" . $searchModel->nama_plafon . "'")
						->andWhere("level = '" . $level_jabatan . "'")
						->One();
				}

				if (isset($data)) {
					$searchModel->nama_plafon = $data->nama_plafon;
					$totalPlafon = $data->nominal;
					$dataTr = $dataProvider->getModels();

					foreach ($dataTr as $da) {
						if ($da->nonbenefit != '*') {
							$pemakaianPlafon = $pemakaianPlafon + $da->biaya;
						}
					}
					$sisaPlafon = $totalPlafon - $pemakaianPlafon;
					$showdiv = true;
				}
			}
		}
		return $this->render('indexpeserta', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
			'showdiv' => $showdiv,
			'showdivA' => $showdivA,
			'totalPlafon' => $totalPlafon,
			'totalPlafonA' => $totalPlafonA,
			'pemakaianPlafon' => $pemakaianPlafon,
			'pemakaianPlafonA' => $pemakaianPlafonA,
			'sisaPlafon' => $sisaPlafon,
			'sisaPlafonA' => $sisaPlafonA,
			'listPlafon' => $listPlafon,
			'listTahun' => $listTahun,
		]);
	}

	public function actionIuranbulanan()
	{
		$this->checkuser();
		$model = new TrPlafon();
		$searchModel = new TrPlafonSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);


		$dataUnitBisnis = MsUnitbisnis::find()
			->select(['unit_bisnis'])
			->orderBy('unit_bisnis')
			->where("unit_bisnis != '-'")
			->all();
		$listUnitBisnis = ArrayHelper::map($dataUnitBisnis, 'unit_bisnis', 'unit_bisnis');

		return $this->render('iuranbulanan', [
			'model' => $model,
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
			'listUnitBisnis' => $listUnitBisnis
		]);
	}

	public function actionRekap()
	{
		$this->checkuser();
		$searchModel = new TrPlafonSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);


		$dataDepartemen = MsDepartemen::find()
			->select(['departemen'])
			->orderBy('departemen')
			->where("departemen != '-'")
			->all();
		$listDepartemen = ArrayHelper::map($dataDepartemen, 'departemen', 'departemen');

		$dataHeader = MsJenisPlafon::find()
			->select(['nama_plafon'])
			->orderBy('nama_plafon asc')
			->all();
		$arrayHeader = [
			0 => 'NO',
			1 => 'NAMA PESERTA'
		];
		$i = 2;
		foreach ($dataHeader as $da) {
			ArrayHelper::setValue($arrayHeader, $i, $da->nama_plafon);
			$i++;
		}

		$listTahun = [];

		$tahunnow = date("Y");
		//var_dump($tahunnow);exit();
		for ($i = 0; $i < 4; $i++) {
			$j = $tahunnow - $i;
			ArrayHelper::setValue($listTahun, $j, $j);
		}

		return $this->render('rekap', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
			'listDepartemen' => $listDepartemen,
			'arrayHeader' => $arrayHeader,
			'listTahun' => $listTahun,
		]);
	}

	public function actionGettrans()
	{
		if (Yii::$app->request->isAjax) {
			Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			$model = new TrPlafon();
			$modelPeserta = new MsPeserta();
			$modelJenisPlafon = new MsJenisPlafon();
			$krt = Yii::$app->request->post('kuartal');
			$dep = Yii::$app->request->post('departemen');
			$vtahun = Yii::$app->request->post('tahun');
			if ($krt == "KUARTAL 1") {
				$where = "tanggal between '$vtahun-01-01' and '$vtahun-03-31'";
			} else if ($krt == "KUARTAL 2") {
				$where = "tanggal between '$vtahun-01-01' and '$vtahun-06-30'";
			} else if ($krt == "KUARTAL 3") {
				$where = "tanggal between '$vtahun-01-01' and '$vtahun-09-30'";
			} else {
				$where = "tanggal between '$vtahun-01-01' and '$vtahun-12-31'";
			}
			// 1;SELECT kode_anggota,nama_peserta from ms_Peserta WHERE departemen = 'IT';
			// 2;SELECT nama_plafon FROM ms_jenisplafon ORDER BY nama_plafon;
			// 3;SELECT ifnull(SUM(biaya),'-') AS biaya FROM tr_plafon WHERE id_peserta IN 
			// (SELECT id FROM ms_peserta WHERE kode_anggota = 'MD-731-03092018')
			// AND nama_plafon = 'rawat jalan' AND tanggal BETWEEN '2020-04-01' AND '2020-06-30';
			$dataPeserta = $modelPeserta->find()
				->select("kode_anggota,nama_peserta")
				->where(['departemen' => $dep])
				->andWhere(['keterangan' => 'PESERTA INDUK'])
				->andWhere('active = 1')
				->orderBy('kode_anggota asc')
				->all();

			$dataJenisPlafon = $modelJenisPlafon->find()
				->select("nama_plafon")
				->orderBy("nama_plafon asc")
				->all();

			$arrayTabel = [];
			$i = 0;
			foreach ($dataPeserta as $dp) {
				$row = "<tr><td>" . ($i + 1) . "</td><td>" . $dp->nama_peserta . "</td>";
				foreach ($dataJenisPlafon as $djp) {
					$dataPlafon = $model->find()
						->select(["SUM(biaya) AS biaya"])
						->where(['nama_plafon' => $djp->nama_plafon])
						->andWhere($where)
						->andWhere("id_peserta in (select id from ms_peserta where kode_anggota = '" . $dp->kode_anggota . "' and active = 1)")
						->one();
					$row .= "<td>Rp " . number_format($dataPlafon->biaya) . "</td>";
				}
				$row .= "</tr>";
				ArrayHelper::setValue($arrayTabel, [$i], ['row' => $row]);
				$i++;
			}



			return [
				'success' => true,
				'departemen' => $dep,
				'kuartal' => $krt,
				'message' => 'Berhasil.',
				'dataRes' => $arrayTabel,
			];
		}
	}

	public function actionGetiuranbulananpeserta()
	{
		if (Yii::$app->request->isAjax) {
			Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			$model = new TrPlafon();
			$modelPeserta = new MsPeserta();
			$modelJenisPlafon = new MsJenisPlafon();
			$modelConfig = new MsConfig();

			$tgl = Yii::$app->request->post('tanggal');
			$unit_bisnis = Yii::$app->request->post('unit_bisnis');

			$dataPeserta = $modelPeserta->find()
				->select("kode_anggota, nama_peserta, keterangan")
				->where('active = 1')
				->andwhere("unit_bisnis = '" . $unit_bisnis . "'")
				->orderBy('kode_anggota asc, id asc')
				->asArray()
				->all();

			$dataIuran = $modelConfig->find()
				->select("value")
				->where("name = 'IURAN PESERTA'")
				->one();

			$dataKota = $modelConfig->find()
				->select("value")
				->where("name = 'KOTA IURAN'")
				->one();

			$dataMenyetujui = $modelConfig->find()
				->select("value")
				->where("name = 'MENYETUJUI IURAN'")
				->one();

			$dataMengetahui = $modelConfig->find()
				->select("value")
				->where("name = 'MENGETAHUI IURAN'")
				->one();

			$dataMembuat = $modelConfig->find()
				->select("value")
				->where("name = 'MEMBUAT IURAN'")
				->one();

			$arrayTabel = [];
			$i = 0;
			foreach ($dataPeserta as $dp) {
				$row = "<tr><td>" . ($i + 1) . "</td><td>" . trim($dp['kode_anggota']) . "</td><td>" . trim($dp['nama_peserta']) . "</td><td>" . trim($dp['keterangan']) . "</td></tr>";
				ArrayHelper::setValue($arrayTabel, [$i], ['row' => $row]);
				$i++;
			}

			return [
				'success' => true,
				'message' => 'Berhasil.',
				'jmlPeserta' => $i,
				'dataRes' => $arrayTabel,
				'iuran' => $dataIuran->value,
				'kota' => $dataKota->value,
				'menyetujui' => $dataMenyetujui->value,
				'mengetahui' => $dataMengetahui->value,
				'membuat' => $dataMembuat->value,
			];
		}
	}
	/**
	 * Displays a single TrPlafon model.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionView($id)
	{
		return $this->render('view', [
			'model' => $this->findModel($id),
		]);
	}

	public function actionViewNonbenefit($id)
	{
		return $this->render('viewnonbenefit', [
			'model' => $this->findModel($id),
		]);
	}

	public function plafonCukup($id_peserta, $nama_plafon, $biaya, $biaya_awal, $tahun)
	{
		$modelTrPlafon = new TrPlafon();
		$modelPeserta = new MsPeserta();
		$plafonModel = new MsPlafon();
		$modelPlafonExtend = new MsPlafonextend();
		$sisaPlafon = 0;
		$tahun = substr($tahun, 0, 4);
		$pemakaianPlafon = $biaya - $biaya_awal;
		$kd_agt = $modelPeserta->find()
			->where("id = '" . $id_peserta . "'")
			->one();
		$kode_anggota = $kd_agt->kode_anggota;
		$dataPeserta = $modelPeserta->find()
			->where("kode_anggota = '" . $kode_anggota . "'")
			->andWhere("keterangan='PESERTA INDUK'")
			->andWhere("active=1")
			->one();
		$level_jabatan = $dataPeserta->level_jabatan;

		if ($nama_plafon == "KECELAKAAN" || Html::like_match('%PEMBEDAHAN%', $nama_plafon)) {
			if ($kd_agt->keterangan == "PESERTA INDUK") {
				$data = $plafonModel->find()
					->where("nama_plafon = '" . $nama_plafon . "'")
					->andWhere("level = '" . $level_jabatan . "'")
					->One();

				if (isset($data)) {
					$totalPlafon = $data->nominal;
					// $dataTr = $modelTrPlafon->find()
					// 	->where("id_peserta = '".$id_peserta."'")
					// 	->andWhere("nama_plafon='".$nama_plafon."'")
					// 	->andWhere("left(tanggal, 4)='".$tahun."'")
					// 	->all();
					// foreach($dataTr as $da){
					// 	$pemakaianPlafon = $pemakaianPlafon + $da->biaya;
					// }
					// $sisaPlafon = $totalPlafon - $pemakaianPlafon;			
					$sisaPlafon = $totalPlafon;
				}
			} else {
				$dataAnggota = $modelPlafonExtend->find()
					->where("nama_plafon = '" . $nama_plafon . "'")
					->One();
				$totalPlafon = $dataAnggota->nominal;
				if (isset($dataAnggota)) {
					$totalPlafon = $dataAnggota->nominal;
					// $dataTr = $modelTrPlafon->find()
					// 	->where("id_peserta = '".$id_peserta."'")
					// 	->andWhere("nama_plafon='".$nama_plafon."'")
					// 	->andWhere("left(tanggal, 4)='".$tahun."'")
					// 	->all();
					// foreach($dataTr as $da){
					// 	$pemakaianPlafon = $pemakaianPlafon + $da->biaya;
					// }
					// $sisaPlafon = $totalPlafon - $pemakaianPlafon;			
					$sisaPlafon = $totalPlafon;
				}
			}
		} else {
			if ($nama_plafon == "RAWAT JALAN" || $nama_plafon == "RAWAT INAP") {
				$anggota = $modelPeserta->find()
					->select(["count(kode_anggota) as kode_anggota"])
					->where("kode_anggota = '" . $kode_anggota . "'")
					->andWhere("active=1")
					->one();
				$jmlAnggota = $anggota->kode_anggota;

				$data = $modelPlafonExtend->find()
					->where("nama_plafon = '" . $nama_plafon . "'")
					->andWhere("level = '" . $level_jabatan . "'")
					->andWhere("jumlah_anggota = '" . $jmlAnggota . "'")
					->One();
			} else {
				$data = $plafonModel->find()
					->where("nama_plafon = '" . $nama_plafon . "'")
					->andWhere("level = '" . $level_jabatan . "'")
					->One();
			}

			if ($nama_plafon == "KACAMATA") {
				$tahunlalu = $tahun - 1;
				$query_tahun = " left(tanggal,4) in ('" . $tahun . "','" . $tahunlalu . "')";
			} else {
				$query_tahun = " left(tanggal,4) = '" . $tahun . "'";
			}

			if (isset($data)) {
				$totalPlafon = $data->nominal;
				$dataTr = $modelTrPlafon->find()
					->where("id_peserta in (select id from ms_peserta where kode_anggota = '" . $kode_anggota . "')")
					->andWhere("nama_plafon='" . $nama_plafon . "'")
					->andWhere($query_tahun)
					->andWhere(['nonbenefit' => null])
					->all();
				foreach ($dataTr as $da) {
					$pemakaianPlafon = $pemakaianPlafon + $da->biaya;
					if ($nama_plafon == "KACAMATA" && $pemakaianPlafon >= 0) {
						return false;
					}
				}
				$sisaPlafon = $totalPlafon - $pemakaianPlafon;
			}
		}

		return $sisaPlafon;
	}

	public function plafonCukupRahmat($id_peserta, $nama_plafon, $biaya, $biaya_awal, $tahun)
	{
		$modelTrPlafon = new TrPlafon();
		$modelPeserta = new MsPeserta();
		$plafonModel = new MsPlafon();
		$modelPlafonExtend = new MsPlafonextend();
		$sisaPlafon = 0;
		$tahun = substr($tahun, 0, 4);
		$pemakaianPlafon = $biaya - $biaya_awal;

		$kd_agt = $modelPeserta->find()
			->where([
				'id' => $id_peserta
			])
			->one();

		$kode_anggota = $kd_agt->kode_anggota;

		$dataPeserta = $modelPeserta->find()
			->where([
				'kode_anggota' => $kode_anggota,
				'keterangan' => 'PESERTA INDUK',
				'active' => 1
			])
			->one();

		$level_jabatan = $dataPeserta->level_jabatan;

		if ($nama_plafon == "KECELAKAAN" || Html::like_match('%PEMBEDAHAN%', $nama_plafon)) {
			if ($kd_agt->keterangan == "PESERTA INDUK") {
				$data = $plafonModel->find()
					->where("nama_plafon = '" . $nama_plafon . "'")
					->andWhere("level = '" . $level_jabatan . "'")
					->One();

				if (isset($data)) {
					$totalPlafon = $data->nominal;
					// $dataTr = $modelTrPlafon->find()
					// 	->where("id_peserta = '".$id_peserta."'")
					// 	->andWhere("nama_plafon='".$nama_plafon."'")
					// 	->andWhere("left(tanggal, 4)='".$tahun."'")
					// 	->all();
					// foreach($dataTr as $da){
					// 	$pemakaianPlafon = $pemakaianPlafon + $da->biaya;
					// }
					// $sisaPlafon = $totalPlafon - $pemakaianPlafon;			
					$sisaPlafon = $totalPlafon;
				}
			} else {
				$dataAnggota = $modelPlafonExtend->find()
					->where("nama_plafon = '" . $nama_plafon . "'")
					->One();
				$totalPlafon = $dataAnggota->nominal;
				if (isset($dataAnggota)) {
					$totalPlafon = $dataAnggota->nominal;
					// $dataTr = $modelTrPlafon->find()
					// 	->where("id_peserta = '".$id_peserta."'")
					// 	->andWhere("nama_plafon='".$nama_plafon."'")
					// 	->andWhere("left(tanggal, 4)='".$tahun."'")
					// 	->all();
					// foreach($dataTr as $da){
					// 	$pemakaianPlafon = $pemakaianPlafon + $da->biaya;
					// }
					// $sisaPlafon = $totalPlafon - $pemakaianPlafon;			
					$sisaPlafon = $totalPlafon;
				}
			}
		} else {
			if ($nama_plafon == "RAWAT JALAN" || $nama_plafon == "RAWAT INAP") {
				$anggota = $modelPeserta->find()
					->select(["count(kode_anggota) as kode_anggota"])
					->where("kode_anggota = '" . $kode_anggota . "'")
					->andWhere("active=1")
					->one();
				$jmlAnggota = $anggota->kode_anggota;

				$data = $modelPlafonExtend->find()
					->where("nama_plafon = '" . $nama_plafon . "'")
					->andWhere("level = '" . $level_jabatan . "'")
					->andWhere("jumlah_anggota = '" . $jmlAnggota . "'")
					->One();
			} else {
				$data = $plafonModel->find()
					->where("nama_plafon = '" . $nama_plafon . "'")
					->andWhere("level = '" . $level_jabatan . "'")
					->One();
			}

			if ($nama_plafon == "KACAMATA") {
				$tahunlalu = $tahun - 1;
				$query_tahun = " left(tanggal,4) in ('" . $tahun . "','" . $tahunlalu . "')";
			} else {
				$query_tahun = " left(tanggal,4) = '" . $tahun . "'";
			}

			// var_dump($data->nominal);
			// exit;

			if (isset($data)) {
				$totalPlafon = $data->nominal;
				$dataTr = $modelTrPlafon->find()
					->where("id_peserta in (select id from ms_peserta where kode_anggota = '" . $kode_anggota . "')")
					->andWhere("nama_plafon='" . $nama_plafon . "'")
					->andWhere($query_tahun)
					->andWhere('nonbenefit IS NULL') // PENAMBAHAN KONDISI APAKAH BENEFIT = NULL
					->all();
				foreach ($dataTr as $da) {
					$pemakaianPlafon = $pemakaianPlafon + $da->biaya;
				}
				$sisaPlafon = $totalPlafon - $pemakaianPlafon;
			}
		}

		// if ($sisaPlafon >= 0) {
		// 	return true;
		// } else {
		// 	return false;
		// }

		return $data->nominal;
	}

	public function actionIndexnonbenefit()
	{
		if (!isset(Yii::$app->user->identity->username)) {
			return $this->redirect(['/site/login']);
		}

		$data = Yii::$app->request->post();

		$searchModel = new TrPlafonSearchPesertaNonbenefit();
		$searchModel->tanggal = date("Y");
		$searchModel->nama_plafon = isset($data['nama_plafon']) ? $data['nama_plafon'] : "";
		$searchModel->nama_peserta = isset($data['nama_peserta']) ? $data['nama_peserta'] : "";
		$searchModel->kode_anggota = isset($data['kode_anggota']) ? $data['kode_anggota'] : "";
		$dataProvider = $searchModel->search($data);
		$dataPlafon = MsJenisPlafon::find()
			->select(['nama_plafon'])
			->orderBy('nama_plafon')
			->all();
		$listPlafon = ArrayHelper::map($dataPlafon, 'nama_plafon', 'nama_plafon');

		$dataTahun = TrPlafon::find()
			->select(['LEFT(tanggal,4) as tanggal'])
			->orderBy('tanggal desc')
			->groupBy(['LEFT(tanggal,4)'])
			->all();
		$listTahun = ArrayHelper::map($dataTahun, 'tanggal', 'tanggal');

		return $this->render('indexnonbenefit', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
			'listPlafon' => $listPlafon,
			'listTahun' => $listTahun,
		]);
	}

	public function actionCreate()
	{
		$this->checkuser();
		$model = new TrPlafon();
		$MsPeserta = new MsPeserta();

		if (Yii::$app->request->isAjax) {

			$data = Yii::$app->request->post();

			if ($model->load($data)) {
				$sisaPlafon = $this->plafonCukup($data['TrPlafon']['id_peserta'], $data['TrPlafon']['nama_plafon'], $data['TrPlafon']['biaya'], 0, $data['TrPlafon']['tanggal']);

				if ($model->nama_plafon == 'KACAMATA') {
					if ($data['TrPlafon']['nonbenefit'] == "*") {
						$model->nonbenefit = $data['TrPlafon']['nonbenefit'];
						$model->keluhan = $data['TrPlafon']['keluhan'];
						$model->tindakan = $data['TrPlafon']['tindakan'];
						$model->keterangan = $data['TrPlafon']['keterangan'];
						$model->invoice = $data['TrPlafon']['invoice'];
						$model->no_surat = $data['TrPlafon']['no_surat'];
						$model->tgl_invoice = $data['TrPlafon']['tgl_invoice'];
						$model->status_bayar = $data['TrPlafon']['status_bayar'];
						$model->biaya = $data['TrPlafon']['biaya'];
						$model->input_by = Yii::$app->user->identity->username;
						$model->input_date = date("Y-m-d H:i:s");

						if ($model->save()) {
							return json_encode([
								'success' => true,
								'message' => 'Data berhasil disimpan',
								'id' => $model->id,
								'data' => $data
							]);
						} else {
							return json_encode([
								'errors' => $model->getErrors()
							]);
						}
					} else {
						if ($sisaPlafon) {
							$model->input_by = Yii::$app->user->identity->username;
							$model->input_date = date("Y-m-d H:i:s");
							if ($model->save()) {
								Yii::$app->session->setFlash('success', "Data Berhasil Disimpan");
								return json_encode([
									'success' => true,
									'message' => 'Data berhasil disimpan',
									'id' => $model->id,
									'data' => $data
								]);
							}
						} else {
							Yii::$app->session->setFlash('error', "Plafon Tidak Mencukupi atau Sudah Dipakai!");
							return $this->redirect(['create']);
						}
					}
				} elseif ($model->nama_plafon == 'KECELAKAAN' || Html::like_match('%PEMBEDAHAN%', $model->nama_plafon)) {
					if ($data['TrPlafon']['biaya'] > $sisaPlafon) {
						return json_encode([
							'success' => false,
							'message' => 'Biaya melebihi sisa plafon!',
							'data' => $data,
						]);
					} else {
						if ($model->save()) {
							Yii::$app->session->setFlash('success', "Data Berhasil Disimpan");
							return json_encode([
								'success' => true,
								'message' => 'Data berhasil disimpan',
								'id' => $model->id,
								'data' => $data
							]);
						} else {
							return json_encode([
								'errors' => $model->getErrors()
							]);
						}
					}
				} else {
					if ($data['TrPlafon']['nonbenefit'] == "*") {
						$model->nonbenefit = $data['TrPlafon']['nonbenefit'];
						$model->keluhan = $data['TrPlafon']['keluhan'];
						$model->tindakan = $data['TrPlafon']['tindakan'];
						$model->keterangan = $data['TrPlafon']['keterangan'];
						$model->invoice = $data['TrPlafon']['invoice'];
						$model->no_surat = $data['TrPlafon']['no_surat'];
						$model->tgl_invoice = $data['TrPlafon']['tgl_invoice'];
						$model->status_bayar = $data['TrPlafon']['status_bayar'];
						$model->biaya = $data['TrPlafon']['biaya'];
						$model->input_by = Yii::$app->user->identity->username;
						$model->input_date = date("Y-m-d H:i:s");

						if ($model->save()) {
							Yii::$app->session->setFlash('success', "Data Berhasil Disimpan");
							return json_encode([
								'success' => true,
								'message' => 'Data berhasil disimpan',
								'id' => $model->id,
								'data' => $data
							]);
						} else {
							return json_encode([
								'errors' => $model->getErrors()
							]);
						}
					} else {
						if ($sisaPlafon < 0) {
							return json_encode([
								'success' => false,
								'message' => 'Biaya melebihi sisa plafon!',
								'data' => $data,
							]);
						} else {
							$model->biaya_inputan = $data['TrPlafon']['biaya'];
							$model->input_by = Yii::$app->user->identity->username;
							$model->input_date = date("Y-m-d H:i:s");
							if ($model->save()) {
								Yii::$app->session->setFlash('success', "Data Berhasil Disimpan");
								return json_encode([
									'success' => true,
									'message' => 'Data berhasil disimpan',
									'id' => $model->id,
									'data' => $data
								]);
							} else {
								return json_encode([
									'errors' => $model->getErrors()
								]);
							}
						}
					}
				}
			}
		}

		$listPeserta = $MsPeserta->listPeserta();

		$dataProvider = MsProvider::find()
			->select(['id', 'nama', 'jenis_provider', 'CONCAT(jenis_provider,\' - \',nama) AS daftar'])
			->orderBy('jenis_provider, nama')
			->all();
		$listProvider = ArrayHelper::map($dataProvider, 'id', 'daftar');

		$dataJenisPlafon = MsJenisPlafon::find()
			->select(['nama_plafon'])
			->orderBy('nama_plafon')
			->all();
		$listJenisPlafon = ArrayHelper::map($dataJenisPlafon, 'nama_plafon', 'nama_plafon');

		$dataStatusPlafon = [
			[
				'id' => 1,
				'status' => 'Ya'
			],
			[
				'id' => 0,
				'status' => 'Tidak'
			]
		];
		$listStatusPlafon = ArrayHelper::map($dataStatusPlafon, 'id', 'status');

		$dataKeterangan = MsNonbenefit::find()
			->select(['value'])
			->orderBy('value')
			->all();
		$listKeterangan = ArrayHelper::map($dataKeterangan, 'value', 'value');

		$dataStatusBayar = [
			[
				'status' => 'Lunas'
			],
			[
				'status' => 'Belum Lunas'
			]
		];
		$listStatusBayar = ArrayHelper::map($dataStatusBayar, 'status', 'status');

		return $this->render('create', [
			'model' => $model,
			'listPeserta' => $listPeserta,
			'listProvider' => $listProvider,
			'listJenisPlafon' => $listJenisPlafon,
			'listStatusPlafon' => $listStatusPlafon,
			'listKeterangan' => $listKeterangan,
			'listStatusBayar' => $listStatusBayar,
		]);
	}

	public function actionCreateOver()
	{
		$this->checkuser();
		$model = new TrPlafon();
		if (Yii::$app->request->isAjax) {
			$data = Yii::$app->request->post();
			$dataPeserta = (new Yii\db\Query())
				->select(['kode_anggota'])
				->from('ms_peserta')
				->where([
					'id' => $data['TrPlafon']['id_peserta']
				])
				->one();
			if ($model->load($data)) {
				$sisaPlafon = $this->plafonCukup($data['TrPlafon']['id_peserta'], $data['TrPlafon']['nama_plafon'], 0, 0, $data['TrPlafon']['tanggal']);

				if ($sisaPlafon <= 0) {
					$model->biaya = $data['TrPlafon']['biaya'];
				} else {
					$model->biaya = $sisaPlafon;
				}

				$model->input_by = Yii::$app->user->identity->username;
				$model->input_date = date("Y-m-d H:i:s");
				$model->biaya_inputan = $data['TrPlafon']['biaya'];
				if ($model->save()) {
					$model_tr_plafon_over = new TrPlafonOver();
					$model_tr_plafon_over->id_peserta = $model->id_peserta;
					$model_tr_plafon_over->id_provider = $model->id_provider;
					$model_tr_plafon_over->id_tr_plafon = $model->id;
					$model_tr_plafon_over->nama_plafon = $model->nama_plafon;
					$model_tr_plafon_over->tanggal = $model->tanggal;
					$model_tr_plafon_over->tanggal_selesai = $model->tanggal_selesai;
					$model_tr_plafon_over->kode_anggota = $dataPeserta['kode_anggota'];

					if ($sisaPlafon < 0) {
						$sisaPlafon = 0;
						$model_tr_plafon_over->biaya = $data['TrPlafon']['biaya'] - $sisaPlafon;
					} else {
						$model_tr_plafon_over->biaya = $data['TrPlafon']['biaya'] - $sisaPlafon;
					}
					if ($model_tr_plafon_over->save()) {
						Yii::$app->session->setFlash('success', "Data Berhasil Disimpan");
						return json_encode([
							'success' => true,
							'message' => 'Data berhasil disimpan',
							'id' => $model->id,
							'data' => $data
						]);
					} else {
						return json_encode([
							'errors' => $model->getErrors()
						]);
					}
				} else {
					return json_encode([
						'errors' => $model->getErrors()
					]);
				}
			}
		}
	}

	/**
	 * Updates an existing TrPlafon model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{
		$this->checkuser();
		$model = $this->findModel($id);

		$biaya_awal = $model->biaya;
		if ($model->load(Yii::$app->request->post())) {
			$data = Yii::$app->request->post();
			$sisaPlafon = $this->plafonCukupRahmat($model->id_peserta, $model->nama_plafon, $model->biaya, $biaya_awal, $model->tanggal);
			$sisaPlafonTerakhir = $this->plafonCukup($model->id_peserta, $model->nama_plafon, $model->biaya, $biaya_awal, $model->tanggal);

			if ($model->nama_plafon == "KACAMATA") {
				if ($data['TrPlafon']['nonbenefit'] == "*") {
					$model->nonbenefit = $data['TrPlafon']['nonbenefit'];
					$model->keluhan = $data['TrPlafon']['keluhan'];
					$model->tindakan = $data['TrPlafon']['tindakan'];
					$model->keterangan = $data['TrPlafon']['keterangan'];
					$model->invoice = $data['TrPlafon']['invoice'];
					$model->no_surat = $data['TrPlafon']['no_surat'];
					$model->tgl_invoice = $data['TrPlafon']['tgl_invoice'];
					$model->status_bayar = $data['TrPlafon']['status_bayar'];
					$model->biaya = $data['TrPlafon']['biaya'];
					$model->input_by = Yii::$app->user->identity->username;
					$model->input_date = date("Y-m-d H:i:s");

					if ($model->save()) {
						return json_encode([
							'success' => true,
							'message' => 'Data berhasil disimpan',
							'id' => $model->id,
							'data' => $data
						]);
					} else {
						return json_encode([
							'errors' => $model->getErrors()
						]);
					}
				} else {
					$sisaPlafon -= $model->biaya;
					if ($sisaPlafon > 0) {
						$model->input_by = Yii::$app->user->identity->username;
						$model->input_date = date("Y-m-d H:i:s");
						if ($model->save()) {
							Yii::$app->session->setFlash('success', "Data Berhasil Disimpan");
							return json_encode([
								'success' => true,
								'message' => 'Data berhasil disimpan',
								'id' => $model->id,
								'data' => $data
							]);
						}
					} else {
						Yii::$app->session->setFlash('error', "Plafon Tidak Mencukupi atau Sudah Dipakai!");
						return $this->redirect(['update', 'id' => $id]);
					}
				}
			} elseif ($model->nama_plafon == 'KECELAKAAN' || Html::like_match('%PEMBEDAHAN%', $model->nama_plafon)) {
				$data['TrPlafon']['sisaPlafon'] = $sisaPlafon;
				$cekOver = $this->findModelOver($id);
				if ($cekOver) {
					if ($data['TrPlafon']['biaya'] + $cekOver->biaya > $sisaPlafonTerakhir) {
						return json_encode([
							'success' => false,
							'message' => 'Biaya melebihi sisa plafon!',
							'data' => $data,
						]);
					} else {
						if ($model->save()) {
							$cekOver->biaya = 0;
							if ($cekOver->save()) {
								Yii::$app->session->setFlash('success', "Data Berhasil Disimpan");
								return json_encode([
									'success' => true,
									'message' => 'Data berhasil disimpan',
									'id' => $model->id,
									'data' => $data
								]);
							}
						} else {
							return json_encode([
								'errors' => $model->getErrors()
							]);
						}
					}
				} else {
					if ($data['TrPlafon']['biaya'] > $sisaPlafonTerakhir) {
						return json_encode([
							'success' => false,
							'message' => 'Biaya melebihi sisa plafon!',
							'data' => $data,
						]);
					} else {
						if ($model->save()) {
							Yii::$app->session->setFlash('success', "Data Berhasil Disimpan");
							return json_encode([
								'success' => true,
								'message' => 'Data berhasil disimpan',
								'id' => $model->id,
								'data' => $data
							]);
						} else {
							return json_encode([
								'errors' => $model->getErrors()
							]);
						}
					}
				}
			} else {
				$data['TrPlafon']['sisaPlafon'] = $sisaPlafon;

				if ($data['TrPlafon']['nonbenefit'] == "*") {
					$model->nonbenefit = $data['TrPlafon']['nonbenefit'];
					$model->keluhan = $data['TrPlafon']['keluhan'];
					$model->tindakan = $data['TrPlafon']['tindakan'];
					$model->keterangan = $data['TrPlafon']['keterangan'];
					$model->invoice = $data['TrPlafon']['invoice'];
					$model->no_surat = $data['TrPlafon']['no_surat'];
					$model->tgl_invoice = $data['TrPlafon']['tgl_invoice'];
					$model->status_bayar = $data['TrPlafon']['status_bayar'];
					$model->biaya = $data['TrPlafon']['biaya'];
					$model->input_by = Yii::$app->user->identity->username;
					$model->input_date = date("Y-m-d H:i:s");

					if ($model->save()) {
						Yii::$app->session->setFlash('success', "Data Berhasil Disimpan");
						return json_encode([
							'success' => true,
							'message' => 'Data berhasil disimpan',
							'id' => $model->id,
							'data' => $data
						]);
					} else {
						return json_encode([
							'errors' => $model->getErrors()
						]);
					}
				} else {
					if ($sisaPlafonTerakhir < 0) {
						return json_encode([
							"success" => false,
							"message" => "Biaya melebihi sisa plafon!",
							"data"	  => $data
						]);
					} else {
						return $this->actionEdit($model->id, $sisaPlafon);
					}
				}
			}
		}

		$dataPeserta = MsPeserta::find()
			->select(['id', 'kode_anggota', 'nama_peserta', 'CONCAT(kode_anggota,\' - \',nama_peserta) AS daftar'])
			->where('active = 1')
			->orderBy('kode_anggota')
			->all();
		$listPeserta = ArrayHelper::map($dataPeserta, 'id', 'daftar');

		$dataProvider = MsProvider::find()
			->select(['id', 'nama', 'jenis_provider', 'CONCAT(jenis_provider,\' - \',nama) AS daftar'])
			->orderBy('jenis_provider, nama')
			->all();
		$listProvider = ArrayHelper::map($dataProvider, 'id', 'daftar');

		$dataJenisPlafon = MsJenisPlafon::find()
			->select(['nama_plafon'])
			->orderBy('nama_plafon')
			->all();
		$listJenisPlafon = ArrayHelper::map($dataJenisPlafon, 'nama_plafon', 'nama_plafon');

		$dataStatusPlafon = [
			[
				'id' => 1,
				'status' => 'Ya'
			],
			[
				'id' => 0,
				'status' => 'Tidak'
			]
		];
		$listStatusPlafon = ArrayHelper::map($dataStatusPlafon, 'id', 'status');

		$dataKeterangan = MsNonbenefit::find()
			->select(['value'])
			->orderBy('value')
			->all();
		$listKeterangan = ArrayHelper::map($dataKeterangan, 'value', 'value');

		$dataStatusBayar = [
			[
				'status' => 'Lunas'
			],
			[
				'status' => 'Belum Lunas'
			]
		];
		$listStatusBayar = ArrayHelper::map($dataStatusBayar, 'status', 'status');

		return $this->render('update', [
			'model' => $model,
			'listPeserta' => $listPeserta,
			'listProvider' => $listProvider,
			'listJenisPlafon' => $listJenisPlafon,
			'listStatusPlafon' => $listStatusPlafon,
			'listKeterangan' => $listKeterangan,
			'listStatusBayar' => $listStatusBayar,
		]);
	}

	public function actionEdit($id, $sisaPlafon)
	{
		$this->checkuser();
		$model = $this->findModel($id);
		if ($model->load(Yii::$app->request->post())) {
			$dataPeserta = (new Yii\db\Query())
				->select(['kode_anggota'])
				->from('ms_peserta')
				->where([
					'id' => $model->id_peserta
				])
				->one();

			if ($model->nama_plafon == 'KECELAKAAN' || Html::like_match('%PEMBEDAHAN%', $model->nama_plafon)) {
				$cekOver = $this->findModelOver($id);
				if ($cekOver) {
					$updateCommand = Yii::$app->db->createCommand()->update(
						'tr_plafon_over',
						[
							'id_peserta' => $model->id_peserta,
							'kode_anggota' => $dataPeserta['kode_anggota'],
							'biaya' => abs(intval($sisaPlafon) - intval($model->biaya)),
							'nama_plafon' => $model->nama_plafon,
							'id_provider' => $model->id_provider,
							'tanggal' => $model->tanggal,
							'tanggal_selesai' => $model->tanggal_selesai
						],
						['id_tr_plafon' => $model->id]
					);

					if (!$updateCommand->execute()) {
						return json_encode([
							'errors' => $updateCommand->pdoStatement->errorInfo()
						]);
					}
				} else {
					$overData = [
						'id_tr_plafon' => $model->id,
						'id_peserta' => $model->id_peserta,
						'kode_anggota' => $dataPeserta['kode_anggota'],
						'biaya' => abs(intval($sisaPlafon) - intval($model->biaya)),
						'nama_plafon' => $model->nama_plafon,
						'id_provider' => $model->id_provider,
						'tanggal' => $model->tanggal,
						'tanggal_selesai' => $model->tanggal_selesai
					];

					$insertCommand = Yii::$app->db->createCommand()->insert('tr_plafon_over', $overData);

					if (!$insertCommand->execute()) {
						return json_encode([
							'errors' => $insertCommand->pdoStatement->errorInfo()
						]);
					}
				}

				$model->biaya = $sisaPlafon;

				if ($model->save()) {
					Yii::$app->session->setFlash('success', "Data Berhasil Disimpan");
					return json_encode([
						"success" => true,
						"message" => "Data berhasil disimpan!",
						"data" => Yii::$app->request->post()
					]);
				}
			} else {
				$model->modi_by = Yii::$app->user->identity->username;
				$model->modi_date = date("Y-m-d H:i:s");
				$model->biaya_inputan = $model->biaya;
				if ($model->save()) {
					$subquery = (new Yii\db\Query())
						->select('id')
						->from('ms_peserta')
						->where(['kode_anggota' => $dataPeserta['kode_anggota']]);

					$data_trans = (new Yii\db\Query())
						->select(["*"])
						->from('tr_plafon')
						->where([
							'id_peserta' => $subquery,
							'nama_plafon' => $model->nama_plafon,
							'nonbenefit' => null
						])
						->orderBy('id ASC')
						->all();

					foreach ($data_trans as $data) {
						$sisaPlafon -= $data["biaya_inputan"];
						if ($sisaPlafon < 0) {
							$excess = abs($sisaPlafon);

							if ($data['biaya_inputan'] >= $excess) {
								$biaya_tr_plafon = $data['biaya_inputan'] - abs($sisaPlafon);
								if ($biaya_tr_plafon == 0) {
									$biaya_tr_plafon = $excess;
								}
								Yii::$app->db->createCommand()->update(
									'tr_plafon',
									[
										'biaya' => $biaya_tr_plafon,
										'modi_by' => Yii::$app->user->identity->username,
										'modi_date' =>  date("Y-m-d H:i:s"),
									],
									['id' => $data['id']]
								)->execute();
							}

							$existingOverData = (new Yii\db\Query())
								->select(["*"])
								->from('tr_plafon_over')
								->where([
									'id_tr_plafon' => $data['id'],
								])
								->one();

							if ($existingOverData) {
								Yii::$app->db->createCommand()->update(
									'tr_plafon_over',
									[
										'biaya' => $excess,
										'id_peserta' => $data['id_peserta'],
										'kode_anggota' => $dataPeserta['kode_anggota'],
										'biaya' => $excess,
										'nama_plafon' => $data['nama_plafon'],
										'id_provider' => $data['id_provider'],
										'tanggal' => $data['tanggal'],
										'tanggal_selesai' => $data['tanggal_selesai'],
									],
									['id_tr_plafon' => $data['id']]
								)->execute();
							} else {
								$overData = [
									'id_tr_plafon' => $data['id'],
									'id_peserta' => $data['id_peserta'],
									'kode_anggota' => $dataPeserta['kode_anggota'],
									'biaya' => $excess,
									'nama_plafon' => $data['nama_plafon'],
									'id_provider' => $data['id_provider'],
									'tanggal' => $data['tanggal'],
									'tanggal_selesai' => $data['tanggal_selesai'],
								];
								Yii::$app->db->createCommand()->insert('tr_plafon_over', $overData)->execute();
							}

							$sisaPlafon = 0;
						} else {
							$existingOverData = (new Yii\db\Query())
								->select(["*"])
								->from('tr_plafon_over')
								->where([
									'id_tr_plafon' => $data['id'],
								])
								->one();
							if ($existingOverData) {
								Yii::$app->db->createCommand()->update('tr_plafon_over', ['biaya' => 0], ['id_tr_plafon' => $data['id']])->execute();
							}
						}
					}

					Yii::$app->session->setFlash('success', "Data Berhasil Disimpan");
					return json_encode([
						"success" => true,
						"message" => "Data berhasil disimpan!",
						"data" => Yii::$app->request->post()
					]);
				} else {
					return json_encode([
						'errors' => $model->getErrors()
					]);
				}
			}
		}
	}

	/**
	 * Deletes an existing TrPlafon model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionDelete($id, $id_peserta, $nama_plafon, $tanggal)
	{
		$this->checkuser();

		$this->findModel($id)->delete();

		$sisaPlafon = $this->plafonCukupRahmat($id_peserta, $nama_plafon, 0, 0, $tanggal);

		if ($nama_plafon == "KACAMATA" || $nama_plafon == "KECELAKAAN" || Html::like_match('%PEMBEDAHAN%', $nama_plafon)) {
			$dataPeserta = (new Yii\db\Query())
				->select(['kode_anggota'])
				->from('ms_peserta')
				->where([
					'id' => $id_peserta
				])
				->one();
			$subquery = (new Yii\db\Query())
				->select('id')
				->from('ms_peserta')
				->where(['kode_anggota' => $dataPeserta['kode_anggota']]);

			$data_trans = (new Yii\db\Query())
				->select(["*"])
				->from('tr_plafon')
				->where([
					'id_peserta' => $subquery,
					'nama_plafon' => $nama_plafon,
					'nonbenefit' => null
				])
				->all();
			
			foreach ($data_trans as $data) {
				$sisaPlafon -= $data["biaya_inputan"];
				if ($sisaPlafon < 0) {
					$excess = abs($sisaPlafon);
					
					if ($data['biaya_inputan'] >= $excess) {
						$biaya_tr_plafon = $data['biaya_inputan'] - abs($sisaPlafon);
						if ($biaya_tr_plafon == 0) {
							$biaya_tr_plafon = $excess;
						}
						Yii::$app->db->createCommand()->update(
							'tr_plafon',
							[
								'biaya' => $biaya_tr_plafon,
								'modi_by' => Yii::$app->user->identity->username,
								'modi_date' =>  date("Y-m-d H:i:s"),
							],
							['id' => $data['id']]
						)->execute();
					}

					$existingOverData = (new Yii\db\Query())
						->select(["*"])
						->from('tr_plafon_over')
						->where([
							'id_tr_plafon' => $data['id'],
						])
						->one();

					if ($existingOverData) {
						Yii::$app->db->createCommand()->update(
							'tr_plafon_over',
							[
								'biaya' => $excess,
								'id_peserta' => $data['id_peserta'],
								'kode_anggota' => $dataPeserta['kode_anggota'],
								'biaya' => $excess,
								'nama_plafon' => $data['nama_plafon'],
								'id_provider' => $data['id_provider'],
								'tanggal' => $data['tanggal'],
								'tanggal_selesai' => $data['tanggal_selesai'],
							],
							['id_tr_plafon' => $data['id']]
						)->execute();
					} else {
						$overData = [
							'id_tr_plafon' => $data['id'],
							'id_peserta' => $data['id_peserta'],
							'kode_anggota' => $dataPeserta['kode_anggota'],
							'biaya' => $excess,
							'nama_plafon' => $data['nama_plafon'],
							'id_provider' => $data['id_provider'],
							'tanggal' => $data['tanggal'],
							'tanggal_selesai' => $data['tanggal_selesai'],
						];
						Yii::$app->db->createCommand()->insert('tr_plafon_over', $overData)->execute();
					}

					$sisaPlafon = 0;
				} else {
					$existingOverData = (new Yii\db\Query())
						->select(["*"])
						->from('tr_plafon_over')
						->where([
							'id_tr_plafon' => $data['id'],
						])
						->one();

					if ($existingOverData) {
						Yii::$app->db->createCommand()->update('tr_plafon', ['biaya' => $data['biaya_inputan']], ['id' => $data['id']])->execute();
						Yii::$app->db->createCommand()->update('tr_plafon_over', ['biaya' => 0], ['id_tr_plafon' => $data['id']])->execute();
					}
				}
			}

		}

		return $this->redirect(['index']);
	}

	/**
	 * Finds the TrPlafon model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return TrPlafon the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		$model = TrPlafon::find()
			->joinWith(['peserta'])
			->joinWith(['provider'])
			->joinWith(['jenisplafon'])
			->where(['tr_plafon.id' => $id])
			->one();
		if ($model !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}

	protected function findModelOver($id)
	{
		$model_tr_plafon_over = TrPlafonOver::find()
			->where([
				'tr_plafon_over.id_tr_plafon' => $id
			])
			->one();
		return $model_tr_plafon_over;
	}
}
