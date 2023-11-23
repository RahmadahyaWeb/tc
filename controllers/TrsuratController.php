<?php

namespace app\controllers;

use app\models\MsConfig;
use Yii;
use app\models\TrSurat;
use app\models\TrSuratSearch;
use app\models\MsPeserta;
use app\models\MsPlafon;
use app\models\MsPlafonextend;
use app\models\MsTujuansurat;
use app\models\MsUpsurat;
use app\models\TrPlafon;
use app\models\User;
use kartik\mpdf\Pdf;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;

/**
 * TrplafonController implements the CRUD actions for TrSurat model.
 */
class TrsuratController extends Controller
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
				'class' => VerbFilter::class,
				'actions' => [
					'delete' => ['POST'],
				],
			],
		];
	}

	/**
	 * Lists all TrSurat models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$this->checkuser();
		$searchModel = new TrSuratSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		//var_dump($searchModel);exit();
		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider
		]);
	}

	/**
	 * Displays a single TrSurat model.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionView($id)
	{
		$this->checkuser();
		return $this->render('view', [
			'model' => $this->findModel($id),
			// 'model' => $model,
		]);
	}

	public function actionCreate()
	{
		$this->checkuser();
		$model = new TrSurat();
		$modelTujuanSurat = new MsTujuansurat();
		$modelUpSurat = new MsUpsurat();
		$modelPeserta = new MsPeserta();
		$modelUser = new User();
		$bulan = $model->getBulanRomawi(date("m"));
		$datapengurus = $modelUser->findByUsername(Yii::$app->user->identity->username);
		if($datapengurus->jabatan == null){
			Yii::$app->session->setFlash('error', "Tidak bisa membuat surat, jabatan Anda belum terisi.");
			return $this->redirect(['index']);
		}

		if ($model->load(Yii::$app->request->post())) {
			$model->no_surat = $model->no_surat . '/TMHRD-TRC/' . $bulan . '/' . date("Y");
			$datapeserta = $modelPeserta->findOne($model->id_peserta);
			$model->id_peserta = $datapeserta->id;
			$model->kode_anggota = $datapeserta->kode_anggota;
			$model->nama_peserta = $datapeserta->nama_peserta;
			$model->alamat_peserta = $datapeserta->alamat;
			$model->nama_pengurus = $datapengurus->username;
			$model->jabatan = $datapengurus->jabatan;
			$model->alamat = $datapengurus->alamat;
			$model->input_by = Yii::$app->user->identity->username;
			$model->input_date = date("Y-m-d H:i:s");
			if ($model->jenis_surat == "Surat Klaim Reject") {
				$model->tujuan_surat = null;
				$model->up_surat = null;
				$model->tgl_exp1 = null;
				$model->tgl_exp2 = null;
			} else if ($model->jenis_surat == "Surat Pengantar Berobat") {
				$model->tgl_terimaclaim = null;
				$model->tujuan_surat = null;
				$model->up_surat = null;
				$model->keterangan_reject = null;
				$model->nominal_reject = null;
			} else {
				$model->tgl_kuitansi = null;
				$model->tgl_terimaclaim = null;
				$model->tgl_exp1 = null;
				$model->tgl_exp2 = null;
				$model->keterangan_reject = null;
				$model->nominal_reject = null;
			}

			if ($model->save()) {
				$model->no_surat = "";
				Yii::$app->session->setFlash('success', "Data Berhasil Disimpan");
				return $this->redirect(['view', 'id' => $model->id]);
			} else {
				Yii::$app->session->setFlash('error', "Data Gagal Disimpan");
				return $this->redirect(['index']);
			}
		}

		$listJenisSurat = $model->listJenisSurat();
		$listTujuanSurat = $modelTujuanSurat->listTujuanSurat();
		$listUpSurat = $modelUpSurat->listUpSurat();
		$listPeserta = $modelPeserta->listPeserta();

		return $this->render('create', [
			'model' => $model,
			'listJenisSurat' => $listJenisSurat,
			'listTujuanSurat' => $listTujuanSurat,
			'listUpSurat' => $listUpSurat,
			'listPeserta' => $listPeserta,
			'bulan' => $bulan
		]);
	}

	/**
	 * Updates an existing TrSurat model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{
		$this->checkuser();
		$model = $this->findModel($id);
		$modelTujuanSurat = new MsTujuansurat();
		$modelUpSurat = new MsUpsurat();
		$modelPeserta = new MsPeserta();
		$modelUser = new User();
		$datapengurus = $modelUser->findByUsername(Yii::$app->user->identity->username);
		if($datapengurus->jabatan == null){
			Yii::$app->session->setFlash('error', "Tidak bisa mengubah surat, jabatan Anda belum terisi.");
			return $this->redirect(['index']);
		}

		if ($model->load(Yii::$app->request->post())) {
			$datapeserta = $modelPeserta->findOne($model->id_peserta);
			$model->id = $datapeserta->id;
			$model->nama_peserta = $datapeserta->nama_peserta;
			$model->alamat_peserta = $datapeserta->alamat;
			$model->nama_pengurus = $datapengurus->username;
			$model->jabatan = $datapengurus->jabatan;
			$model->alamat = $datapengurus->alamat;
			$model->modi_by = Yii::$app->user->identity->username;
			$model->modi_date = date("Y-m-d H:i:s");
			if ($model->jenis_surat == "Surat Klaim Reject") {
				$model->tujuan_surat = null;
				$model->up_surat = null;
				$model->tgl_exp1 = null;
				$model->tgl_exp2 = null;
			} else if ($model->jenis_surat == "Surat Pengantar Berobat") {
				$model->tgl_terimaclaim = null;
				$model->tujuan_surat = null;
				$model->up_surat = null;
				$model->keterangan_reject = null;
				$model->nominal_reject = null;
			} else {
				$model->tgl_kuitansi = null;
				$model->tgl_terimaclaim = null;
				$model->tgl_exp1 = null;
				$model->tgl_exp2 = null;
				$model->keterangan_reject = null;
				$model->nominal_reject = null;
			}
			if ($model->save()) {
				Yii::$app->session->setFlash('success', "Data Berhasil Diperbarui");
				return $this->redirect(['view', 'id' => $model->id]);
			} else {
				Yii::$app->session->setFlash('error', "Data Gagal Diperbarui");
				return $this->redirect(['index']);
			}
		}

		$listJenisSurat = $model->listJenisSurat();
		$listTujuanSurat = $modelTujuanSurat->listTujuanSurat();
		$listUpSurat = $modelUpSurat->listUpSurat();
		$listPeserta = $modelPeserta->listPeserta();

		return $this->render('update', [
			'model' => $model,
			'listJenisSurat' => $listJenisSurat,
			'listTujuanSurat' => $listTujuanSurat,
			'listUpSurat' => $listUpSurat,
			'listPeserta' => $listPeserta,
		]);
	}
	/**
	 * Deletes an existing TrSurat model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionDelete($id)
	{
		$this->checkuser();
		if ($this->findModel($id)->delete()) {
			Yii::$app->session->setFlash('success', "Data Berhasil Dihapus");
		} else {
			Yii::$app->session->setFlash('error', "Data Gagal Dihapus");
		}


		return $this->redirect(['index']);
	}

	/**
	 * Finds the TrSurat model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return TrSurat the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		$model = TrSurat::find()
			->where(['tr_surat.id' => $id])
			->one();
		if ($model !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}

	public function month_name($m)
	{
		$month = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
		return $month[intval($m) - 1];
	}
	
	public function actionPrinttest($id){
		$model = $this->findModel($id);
		$modelConfig = new MsConfig();
		$modelpeserta = new MsPeserta();
		$modelplafon = new MsPlafon();
		$modelplafonextend = new MsPlafonextend();
		$modeltrplafon = new TrPlafon();
		$jenissurat = $model->jenis_surat;
		$tgl = strtotime($model->tgl_surat);
		$tglSurat = date("d", $tgl) . " " . $this->month_name(date("m", $tgl)) . " " . date("Y", $tgl);
		$peserta = $modelpeserta->findOne($model->id_peserta);
		$jmlAnggota = $modelpeserta->getJumlahAnggota($peserta->kode_anggota);
		$dataMengetahui = $modelConfig->find()
				->select("value")
				->where("name = 'MENGETAHUI IURAN'")
				->one();

			$pesertainduk = $modelpeserta->getPesertaInduk($peserta->kode_anggota);
			if ($peserta->keterangan <> 'PESERTA INDUK') {
				if ($peserta->keterangan == 'ISTRI') {
					$nama_peserta = $model->nama_peserta . " (Istri Bpk. " . $pesertainduk->nama_peserta . ")";
				} else if ($peserta->keterangan == 'SUAMI') {
					$nama_peserta = $model->nama_peserta . " (Suami Ibu " . $pesertainduk->nama_peserta . ")";
				} else {
					if($pesertainduk->jenis_kelamin == 'L'){
						$nama_peserta = $model->nama_peserta . " (Anak Bpk. " . $pesertainduk->nama_peserta . ")";
					} else {
						$nama_peserta = $model->nama_peserta . " (Anak Ibu " . $pesertainduk->nama_peserta . ")";
					}
				}
				$model->nama_peserta = $nama_peserta;
				$plafonkecelakaan = $modelplafonextend->getDataPlafon('KECELAKAAN', 'TANGGUNGAN', 1);
				$plafonbedahkecil = $modelplafonextend->getDataPlafon('PEMBEDAHAN KECIL', 'TANGGUNGAN', 1);
				$plafonbedahsedang = $modelplafonextend->getDataPlafon('PEMBEDAHAN SEDANG', 'TANGGUNGAN', 1);
				$plafonbedahbesar = $modelplafonextend->getDataPlafon('PEMBEDAHAN BESAR', 'TANGGUNGAN', 1);
			} else {
				$plafonkecelakaan = $modelplafon->getDataPlafon('KECELAKAAN', $peserta->level_jabatan);
				$plafonbedahkecil = $modelplafon->getDataPlafon('PEMBEDAHAN KECIL', $peserta->level_jabatan);
				$plafonbedahsedang = $modelplafon->getDataPlafon('PEMBEDAHAN SEDANG', $peserta->level_jabatan);
				$plafonbedahbesar = $modelplafon->getDataPlafon('PEMBEDAHAN BESAR', $peserta->level_jabatan);
				$nama_peserta = $model->nama_peserta . " (Peserta)";
			}
			$model->nama_peserta = $nama_peserta;

			$plafonkamar = $modelplafon->getDataPlafon('KAMAR RAWAT INAP', $peserta->level_jabatan);
			$plafonkunjungan = $modelplafon->getDataPlafon('KUNJUNGAN DOKTER', $peserta->level_jabatan);
			$plafonctscan = $modelplafon->getDataPlafon('CT SCAN & MRI', $peserta->level_jabatan);
			$plafonrawatinap = $modelplafonextend->getDataPlafon('RAWAT INAP', $peserta->level_jabatan, $jmlAnggota);

			$dataTr = $modeltrplafon->getAllTransPertahun($model->kode_anggota, 'RAWAT INAP', date("Y", $tgl));
			$pemakaianPlafon = 0;
			$sisaplafoninap = $plafonrawatinap->nominal - $pemakaianPlafon;
			$sisahari = 30;

			foreach ($dataTr as $da) {
				if ($da->biaya > 0) {
					$sisaplafoninap = $sisaplafoninap - $da->biaya;
					$hari = round(((strtotime($da->tanggal_selesai) - strtotime($da->tanggal)) / (60 * 60 * 24))) + 1;
					$sisahari = $sisahari - $hari;
				}
			}

			$thisdata = (object)[
				'plafonkamar' => number_format($plafonkamar->nominal, 0, ',', '.'),
				'plafonkunjungan' => number_format($plafonkunjungan->nominal, 0, ',', '.'),
				'plafonkecelakaan' => number_format($plafonkecelakaan->nominal, 0, ',', '.'),
				'plafonbedahkecil' => number_format($plafonbedahkecil->nominal, 0, ',', '.'),
				'plafonbedahsedang' => number_format($plafonbedahsedang->nominal, 0, ',', '.'),
				'plafonbedahbesar' => number_format($plafonbedahbesar->nominal, 0, ',', '.'),
				'plafonctscan' => number_format($plafonctscan->nominal, 0, ',', '.'),
				'sisahari' => $sisahari,
				'sisaplafoninap' => number_format($sisaplafoninap, 0, ',', '.'),
			];

			$content = $this->renderpartial('suratjaminanrawatinapp', [
				'data' => $model,
				'tglSurat' => $tglSurat,
				'thisdata' => $thisdata
			]);
			
			// return $content;
			$pdf = new Pdf([
				'mode' => Pdf::MODE_CORE,
				'format' => Pdf::FORMAT_LEGAL,
				'filename' => 'SuratOnline - ' . str_replace("/", "-", $model->no_surat) . '.pdf',
				'destination' => Pdf::DEST_BROWSER,
				// 'destination' => Pdf::DEST_DOWNLOAD, //DEST_BROWSER, DEST_FILE, DEST_STRING
				'content' => $content,
				'cssInline' => '
					#maindiv{
						font-size: 14.3px;
					},
					#divtable0{
						margin-left: -2px;
					},
					#divtable1{
						margin-left: 50px;
					},
					#divtable2{
						margin-left: 50px;
					},
					td{
						padding:0px;
						vertical-align: top;
						text-align: justify;
						text-justify: inter-word;
						font-size: 14.3px;
					},
					li{
						text-align: justify;
						text-justify: inter-word;
					}
					',
				'methods' => [
					'SetTitle' => ['Cetak Surat Online'],
					// 'SetHeader' => [$model->jenis_surat],
					// 'SetFooter' => ['{PAGENO}'],
				]
			]);
			return $pdf->render();
	}

	public function actionPrint($id)
	{
		$model = $this->findModel($id);
		$modelConfig = new MsConfig();
		$modelpeserta = new MsPeserta();
		$modelplafon = new MsPlafon();
		$modelplafonextend = new MsPlafonextend();
		$modeltrplafon = new TrPlafon();
		$jenissurat = $model->jenis_surat;
		$tgl = strtotime($model->tgl_surat);
		$tglSurat = date("d", $tgl) . " " . $this->month_name(date("m", $tgl)) . " " . date("Y", $tgl);
		$peserta = $modelpeserta->findOne($model->id_peserta);
		$jmlAnggota = $modelpeserta->getJumlahAnggota($peserta->kode_anggota);
		$dataMengetahui = $modelConfig->find()
				->select("value")
				->where("name = 'MENGETAHUI IURAN'")
				->one();

		if ($jenissurat == 'Surat Jaminan Rawat Inap') {
			$pesertainduk = $modelpeserta->getPesertaInduk($peserta->kode_anggota);
			if ($peserta->keterangan <> 'PESERTA INDUK') {
				if ($peserta->keterangan == 'ISTRI') {
					$nama_peserta = $model->nama_peserta . " (Istri Bpk. " . $pesertainduk->nama_peserta . ")";
				} else if ($peserta->keterangan == 'SUAMI') {
					$nama_peserta = $model->nama_peserta . " (Suami Ibu " . $pesertainduk->nama_peserta . ")";
				} else {
					if($pesertainduk->jenis_kelamin == 'L'){
						$nama_peserta = $model->nama_peserta . " (Anak Bpk. " . $pesertainduk->nama_peserta . ")";
					} else {
						$nama_peserta = $model->nama_peserta . " (Anak Ibu " . $pesertainduk->nama_peserta . ")";
					}
				}
				$model->nama_peserta = $nama_peserta;
				$plafonkecelakaan = $modelplafonextend->getDataPlafon('KECELAKAAN', 'TANGGUNGAN', 1);
				$plafonbedahkecil = $modelplafonextend->getDataPlafon('PEMBEDAHAN KECIL', 'TANGGUNGAN', 1);
				$plafonbedahsedang = $modelplafonextend->getDataPlafon('PEMBEDAHAN SEDANG', 'TANGGUNGAN', 1);
				$plafonbedahbesar = $modelplafonextend->getDataPlafon('PEMBEDAHAN BESAR', 'TANGGUNGAN', 1);
			} else {
				$plafonkecelakaan = $modelplafon->getDataPlafon('KECELAKAAN', $peserta->level_jabatan);
				$plafonbedahkecil = $modelplafon->getDataPlafon('PEMBEDAHAN KECIL', $peserta->level_jabatan);
				$plafonbedahsedang = $modelplafon->getDataPlafon('PEMBEDAHAN SEDANG', $peserta->level_jabatan);
				$plafonbedahbesar = $modelplafon->getDataPlafon('PEMBEDAHAN BESAR', $peserta->level_jabatan);
				$nama_peserta = $model->nama_peserta . " (Peserta)";
			}
			$model->nama_peserta = $nama_peserta;

			$plafonkamar = $modelplafon->getDataPlafon('KAMAR RAWAT INAP', $peserta->level_jabatan);
			$plafonkunjungan = $modelplafon->getDataPlafon('KUNJUNGAN DOKTER', $peserta->level_jabatan);
			$plafonctscan = $modelplafon->getDataPlafon('CT SCAN & MRI', $peserta->level_jabatan);
			$plafonrawatinap = $modelplafonextend->getDataPlafon('RAWAT INAP', $peserta->level_jabatan, $jmlAnggota);

			$dataTr = $modeltrplafon->getAllTransPertahun($model->kode_anggota, 'RAWAT INAP', date("Y", $tgl));
			$pemakaianPlafon = 0;
			$sisaplafoninap = $plafonrawatinap->nominal - $pemakaianPlafon;
			$sisahari = 30;

			foreach ($dataTr as $da) {
				if ($da->biaya > 0) {
					$sisaplafoninap = $sisaplafoninap - $da->biaya;
					$hari = round(((strtotime($da->tanggal_selesai) - strtotime($da->tanggal)) / (60 * 60 * 24))) + 1;
					$sisahari = $sisahari - $hari;
				}
			}

			$thisdata = (object)[
				'plafonkamar' => number_format($plafonkamar->nominal, 0, ',', '.'),
				'plafonkunjungan' => number_format($plafonkunjungan->nominal, 0, ',', '.'),
				'plafonkecelakaan' => number_format($plafonkecelakaan->nominal, 0, ',', '.'),
				'plafonbedahkecil' => number_format($plafonbedahkecil->nominal, 0, ',', '.'),
				'plafonbedahsedang' => number_format($plafonbedahsedang->nominal, 0, ',', '.'),
				'plafonbedahbesar' => number_format($plafonbedahbesar->nominal, 0, ',', '.'),
				'plafonctscan' => number_format($plafonctscan->nominal, 0, ',', '.'),
				'sisahari' => $sisahari,
				'sisaplafoninap' => number_format($sisaplafoninap, 0, ',', '.'),
			];

			$content = $this->renderPartial('suratjaminanrawatinap', [
				'data' => $model,
				'tglSurat' => $tglSurat,
				'thisdata' => $thisdata
			]);
			
			$pdf = new Pdf([
				'mode' => Pdf::MODE_CORE,
				'format' => Pdf::FORMAT_LEGAL,
				'filename' => 'SuratOnline - ' . str_replace("/", "-", $model->no_surat) . '.pdf',
				'destination' => Pdf::DEST_BROWSER,
				// 'destination' => Pdf::DEST_DOWNLOAD, //DEST_BROWSER, DEST_FILE, DEST_STRING
				'content' => $content,
				'cssInline' => '
					#maindiv{
						font-size: 14.3px;
					},
					#divtable0{
						margin-left: -2px;
					},
					#divtable1{
						margin-left: 50px;
					},
					#divtable2{
						margin-left: 50px;
					},
					td{
						padding:0px;
						vertical-align: top;
						text-align: justify;
						text-justify: inter-word;
						font-size: 14.3px;
					},
					li{
						text-align: justify;
						text-justify: inter-word;
					}
					',
				'methods' => [
					'SetTitle' => ['Cetak Surat Online'],
					// 'SetHeader' => [$model->jenis_surat],
					// 'SetFooter' => ['{PAGENO}'],
				]
			]);
			return $pdf->render();
		} else if ($jenissurat == "Surat Jaminan Melahirkan") {
			$pesertainduk = $modelpeserta->getPesertaInduk($peserta->kode_anggota);
			$model->nama_peserta = $model->nama_peserta . " (Istri Bpk. " . $pesertainduk->nama_peserta . ")";
			$plafonpersalinanbidan = $modelplafon->getDataPlafon('PERSALINAN DENGAN BANTUAN BIDAN', $peserta->level_jabatan);
			$plafonpersalinandokternormal = $modelplafon->getDataPlafon('PERSALINAN DENGAN BANTUAN DOKTER (NORMAL)', $peserta->level_jabatan);
			$plafonpersalinandoktercesar = $modelplafon->getDataPlafon('PERSALINAN DENGAN BANTUAN DOKTER (CAESAR)', $peserta->level_jabatan);
			$plafonpersalinanektopik = $modelplafon->getDataPlafon('PERSALINAN DILUAR RAHIM (KEHAMILAN EKTOPIK)', $peserta->level_jabatan);
			$plafonkuret = $modelplafon->getDataPlafon('VAKUM ASPIRASI/KURET', $peserta->level_jabatan);

			$thisdata = (object)[
				'plafonpersalinanbidan' => number_format($plafonpersalinanbidan->nominal, 0, ',', '.'),
				'plafonpersalinandokternormal' => number_format($plafonpersalinandokternormal->nominal, 0, ',', '.'),
				'plafonpersalinandoktercesar' => number_format($plafonpersalinandoktercesar->nominal, 0, ',', '.'),
				'plafonpersalinanektopik' => number_format($plafonpersalinanektopik->nominal, 0, ',', '.'),
				'plafonkuret' => number_format($plafonkuret->nominal, 0, ',', '.'),
				't_plafonpersalinanbidan' => $this->terbilang($plafonpersalinanbidan->nominal),
				't_plafonpersalinandokternormal' => $this->terbilang($plafonpersalinandokternormal->nominal),
				't_plafonpersalinandoktercesar' => $this->terbilang($plafonpersalinandoktercesar->nominal),
				't_plafonpersalinanektopik' => $this->terbilang($plafonpersalinanektopik->nominal),
				't_plafonkuret' => $this->terbilang($plafonkuret->nominal)
			];

			$content = $this->renderPartial('suratjaminanmelahirkan', [
				'data' => $model,
				'tglSurat' => $tglSurat,
				'thisdata' => $thisdata
			]);

			$pdf = new Pdf([
				'mode' => Pdf::MODE_CORE,
				'format' => Pdf::FORMAT_LEGAL,
				'filename' => 'SuratOnline - ' . str_replace("/", "-", $model->no_surat) . '.pdf',
				'destination' => Pdf::DEST_BROWSER,
				// 'destination' => Pdf::DEST_DOWNLOAD, //DEST_BROWSER, DEST_FILE, DEST_STRING
				'content' => $content,
				'cssInline' => '
					#maindiv{
						font-size: 14.3px;
					},
					#divtable0{
						margin-left: -2px;
					},
					#divtable1{
						margin-left: 50px;
					},
					#divtable2{
						margin-left: 50px;
					},
					td{
						padding:0px;
						vertical-align: top;
						text-align: justify;
						text-justify: inter-word;
						font-size: 14.3px;
					},
					li{
						text-align: justify;
						text-justify: inter-word;
					}
					',
				'methods' => [
					'SetTitle' => ['Cetak Surat Online'],
					// 'SetHeader' => [$model->jenis_surat],
					// 'SetFooter' => ['{PAGENO}'],
				]
			]);
			return $pdf->render();
		} else if ($jenissurat == "Surat Jaminan Kecelakaan") {
			$pesertainduk = $modelpeserta->getPesertaInduk($peserta->kode_anggota);
			if ($peserta->keterangan <> 'PESERTA INDUK') {
				if ($peserta->keterangan == 'ISTRI') {
					$nama_peserta = $model->nama_peserta . " (Istri Bpk. " . $pesertainduk->nama_peserta . ")";
				} else if ($peserta->keterangan == 'SUAMI') {
					$nama_peserta = $model->nama_peserta . " (Suami Ibu " . $pesertainduk->nama_peserta . ")";
				} else {
					if($pesertainduk->jenis_kelamin == 'L'){
						$nama_peserta = $model->nama_peserta . " (Anak Bpk. " . $pesertainduk->nama_peserta . ")";
					} else {
						$nama_peserta = $model->nama_peserta . " (Anak Ibu " . $pesertainduk->nama_peserta . ")";
					}
				}
				$model->nama_peserta = $nama_peserta;
				$plafonkecelakaan = $modelplafonextend->getDataPlafon('KECELAKAAN', 'TANGGUNGAN', 1);
			} else {
				$plafonkecelakaan = $modelplafon->getDataPlafon('KECELAKAAN', $peserta->level_jabatan);
				$nama_peserta = $model->nama_peserta . " (Peserta)";
			}
			$model->nama_peserta = $nama_peserta;


			$thisdata = (object)[
				'plafonkecelakaan' => number_format($plafonkecelakaan->nominal, 0, ',', '.')
			];

			$content = $this->renderPartial('suratjaminankecelakaan', [
				'data' => $model,
				'tglSurat' => $tglSurat,
				'thisdata' => $thisdata
			]);

			$pdf = new Pdf([
				'mode' => Pdf::MODE_CORE,
				'format' => Pdf::FORMAT_A4,
				'filename' => 'SuratOnline - ' . str_replace("/", "-", $model->no_surat) . '.pdf',
				'destination' => Pdf::DEST_BROWSER,
				// 'destination' => Pdf::DEST_DOWNLOAD, //DEST_BROWSER, DEST_FILE, DEST_STRING
				'content' => $content,
				'cssInline' => '
					#maindiv{
						font-size: 14.3px;
					},
					#divtable0{
						margin-left: -2px;
					},
					#divtable1{
						margin-left: 50px;
					},
					#divtable2{
						margin-left: 50px;
					},
					td{
						padding:0px;
						vertical-align: top;
						text-align: justify;
						text-justify: inter-word;
						font-size: 14.3px;
					},
					li{
						text-align: justify;
						text-justify: inter-word;
					}
					',
				'methods' => [
					'SetTitle' => ['Cetak Surat Online'],
					// 'SetHeader' => [$model->jenis_surat],
					// 'SetFooter' => ['{PAGENO}'],
				]
			]);
			return $pdf->render();
		} else if ($jenissurat == "Surat Pengantar Berobat") {
			$pesertainduk = $modelpeserta->getPesertaInduk($peserta->kode_anggota);
			if ($peserta->keterangan <> 'PESERTA INDUK') {
				if ($peserta->keterangan == 'ISTRI') {
					$nama_peserta = $model->nama_peserta . " (Istri Bpk. " . $pesertainduk->nama_peserta . ")";
				} else if ($peserta->keterangan == 'SUAMI') {
					$nama_peserta = $model->nama_peserta . " (Suami Ibu " . $pesertainduk->nama_peserta . ")";
				} else {
					if($pesertainduk->jenis_kelamin == 'L'){
						$nama_peserta = $model->nama_peserta . " (Anak Bpk. " . $pesertainduk->nama_peserta . ")";
					} else {
						$nama_peserta = $model->nama_peserta . " (Anak Ibu " . $pesertainduk->nama_peserta . ")";
					}
				}
				$model->nama_peserta = $nama_peserta;
			} else {
				$nama_peserta = $model->nama_peserta . " (Peserta)";
			}
			$model->nama_peserta = $nama_peserta;

			$tgl_kuitansi = strtotime($model->tgl_kuitansi);
			$tgl_exp1 = strtotime($model->tgl_exp1);
			$tgl_exp2 = strtotime($model->tgl_exp2);

			$tglExp1 = date("d", $tgl_exp1) . " " . $this->month_name(date("m", $tgl_exp1)) . " " . date("Y", $tgl_exp1);
			$tglExp2 = date("d", $tgl_exp2) . " " . $this->month_name(date("m", $tgl_exp2)) . " " . date("Y", $tgl_exp2);
			$model->tgl_kuitansi = date("d", $tgl_kuitansi) . " " . $this->month_name(date("m", $tgl_kuitansi)) . " " . date("Y", $tgl_kuitansi);
			$masaberlaku = $tglExp1 . " s/d " . $tglExp2;

			if ($pesertainduk->unit_bisnis == "MAIN DEALER DIRECT SALES") {
				$pesertainduk->unit_bisnis = "PT TRIO MOTOR (DIRECT SALES)";
			} else if ($pesertainduk->unit_bisnis == "MAIN DEALER PUSAT") {
				$pesertainduk->unit_bisnis = "PT TRIO MOTOR";
			} else if ($pesertainduk->unit_bisnis == "PART CENTER") {
				$pesertainduk->unit_bisnis = "PT TRIO MOTOR (PART CENTER)";
			}

			$content = $this->renderPartial('suratpengantarberobat', [
				'data' => $model,
				'datainduk' => $pesertainduk,
				'tglSurat' => $tglSurat,
				'masaberlaku' => $masaberlaku
			]);

			$pdf = new Pdf([
				'mode' => Pdf::MODE_CORE,
				'format' => Pdf::FORMAT_A4,
				'filename' => 'SuratOnline - ' . str_replace("/", "-", $model->no_surat) . '.pdf',
				'destination' => Pdf::DEST_BROWSER,
				// 'destination' => Pdf::DEST_DOWNLOAD, //DEST_BROWSER, DEST_FILE, DEST_STRING
				'content' => $content,
				'cssInline' => '
					#divpage{
						position:absolute;
						font-size: 14.3px;
					},
					#maindiv{
						font-size: 14.3px;
					},
					#divtable0{
						//margin-left: -2px;
						width: 100%;
					},
					#tableheader{
						width: 100%;
					},
					#tablepage{
						float:left;
					},
					#divtable1{
						margin-left: 110px;
					},
					#divtable2{
						margin-left: -4px;
					},
					td{
						//padding:0px;
						vertical-align: top;
						text-align: justify;
						text-justify: inter-word;
						font-size: 14.3px;
					},
					li{
						text-align: justify;
						text-justify: inter-word;
					}
					',
				'methods' => [
					'SetTitle' => ['Cetak Surat Online'],
					// 'SetHeader' => [$model->jenis_surat],
					// 'SetFooter' => ['{PAGENO}'],
				]
			]);
			return $pdf->render();
		} else if ($jenissurat == "Surat Klaim Reject") {
			$pesertainduk = $modelpeserta->getPesertaInduk($peserta->kode_anggota);
			if ($peserta->keterangan <> 'PESERTA INDUK') {
				if ($peserta->keterangan == 'ISTRI') {
					$nama_peserta = $model->nama_peserta . " (Istri Bpk. " . $pesertainduk->nama_peserta . ")";
				} else if ($peserta->keterangan == 'SUAMI') {
					$nama_peserta = $model->nama_peserta . " (Suami Ibu " . $pesertainduk->nama_peserta . ")";
				} else {
					if($pesertainduk->jenis_kelamin == 'L'){
						$nama_peserta = $model->nama_peserta . " (Anak Bpk. " . $pesertainduk->nama_peserta . ")";
					} else {
						$nama_peserta = $model->nama_peserta . " (Anak Ibu " . $pesertainduk->nama_peserta . ")";
					}
				}
				$model->nama_peserta = $nama_peserta;
			} else {
				$nama_peserta = $model->nama_peserta . " (Peserta)";
			}
			$model->nama_peserta = $nama_peserta;

			$tgl_kuitansi = strtotime($model->tgl_kuitansi);
			$tgl_terimaclaim = strtotime($model->tgl_terimaclaim);
			
			$model->tgl_kuitansi = date("d", $tgl_kuitansi) . " " . $this->month_name(date("m", $tgl_kuitansi)) . " " . date("Y", $tgl_kuitansi);
			$model->tgl_terimaclaim = date("d", $tgl_terimaclaim) . " " . $this->month_name(date("m", $tgl_terimaclaim)) . " " . date("Y", $tgl_terimaclaim);
			
			if ($pesertainduk->unit_bisnis == "MAIN DEALER DIRECT SALES") {
				$pesertainduk->unit_bisnis = "PT TRIO MOTOR (DIRECT SALES)";
			} else if ($pesertainduk->unit_bisnis == "MAIN DEALER PUSAT") {
				$pesertainduk->unit_bisnis = "PT TRIO MOTOR";
			} else if ($pesertainduk->unit_bisnis == "PART CENTER") {
				$pesertainduk->unit_bisnis = "PT TRIO MOTOR (PART CENTER)";
			}
			$content = $this->renderPartial('suratklaimreject', [
				'data' => $model,
				'datainduk' => $pesertainduk,
				'tglSurat' => $tglSurat,
				'mengetahui' => $dataMengetahui->value,
			]);

			$pdf = new Pdf([
				'mode' => Pdf::MODE_CORE,
				'format' => Pdf::FORMAT_A4,
				'filename' => 'SuratOnline - ' . str_replace("/", "-", $model->no_surat) . '.pdf',
				'destination' => Pdf::DEST_BROWSER,
				// 'destination' => Pdf::DEST_DOWNLOAD, //DEST_BROWSER, DEST_FILE, DEST_STRING
				'content' => $content,
				'cssInline' => '
					#divpage{
						position:absolute;
						font-size: 14.3px;
					},
					#maindiv{
						font-size: 14.3px;
					},
					#divtable1{
						margin-left: 50px;
					},
					#tabledetail{
						width:100%;
						border:1px solid black;
						border-collapse:collapse;
					},
					#tabledetail td,th{
						text-align:center;
						border:1px solid black;
						padding:10px;
					},
					#divtable2{
						width:100%;
					},
					td{
						vertical-align: top;
						text-align: justify;
						text-justify: inter-word;
						font-size: 14.3px;
					},
					li{
						text-align: justify;
						text-justify: inter-word;
					}
					',
				'methods' => [
					'SetTitle' => ['Cetak Surat Online'],
					// 'SetHeader' => [$model->jenis_surat],
					// 'SetFooter' => ['{PAGENO}'],
				]
			]);
			return $pdf->render();
		} else {
			Yii::$app->session->setFlash('error', "Jenis Surat Tidak Dikenali");
			return $this->redirect(['index']);
		}
	}

	function penyebut($nilai)
	{
		$nilai = abs($nilai);
		$huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " " . $huruf[$nilai];
		} else if ($nilai < 20) {
			$temp = $this->penyebut($nilai - 10) . " Belas";
		} else if ($nilai < 100) {
			$temp = $this->penyebut($nilai / 10) . " Puluh" . $this->penyebut($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " seratus" . $this->penyebut($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = $this->penyebut($nilai / 100) . " Ratus" . $this->penyebut($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " seribu" . $this->penyebut($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = $this->penyebut($nilai / 1000) . " Ribu" . $this->penyebut($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = $this->penyebut($nilai / 1000000) . " Juta" . $this->penyebut($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = $this->penyebut($nilai / 1000000000) . " Milyar" . $this->penyebut(fmod($nilai, 1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = $this->penyebut($nilai / 1000000000000) . " Trilyun" . $this->penyebut(fmod($nilai, 1000000000000));
		}
		return $temp;
	}

	function terbilang($nilai)
	{
		if ($nilai < 0) {
			$hasil = "minus " . trim($this->penyebut($nilai));
		} else {
			$hasil = trim($this->penyebut($nilai));
		}
		return $hasil . " Rupiah";
	}
}
