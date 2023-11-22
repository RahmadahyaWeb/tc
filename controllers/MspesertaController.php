<?php

namespace app\controllers;

use Yii;
use app\models\MsPeserta;
use app\models\MsDepartemen;
use app\models\MsHRD;
use app\models\MsUnitBisnis;
use app\models\MsLevel;
use app\models\MspesertaSearch;
use app\models\User;
use Exception;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kartik\mpdf\Pdf;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\rest\UpdateAction;

/**
 * MspesertaController implements the CRUD actions for MsPeserta model.
 */
class MspesertaController extends Controller
{
	public function init()
	{
		parent::init();
		// if(Yii::$app->user->identity->user_group != 'admin') {
		// return $this->goHome();
		// }
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
	 * Lists all MsPeserta models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchModel = new MspesertaSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->get());
		$dataProvider->pagination->pageSize = 5;

		return $this->render('index', [
			'dataProvider' => $dataProvider,
			'searchModel' => $searchModel,
		]);
	}

	/**
	 * Displays a single MsPeserta model.
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

	/**
	 * Creates a new MsPeserta model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new MsPeserta();

		$dataDepartemen = MsDepartemen::find()
			->select(['departemen'])
			->orderBy('departemen')
			->all();
		$listDepartemen = ArrayHelper::map($dataDepartemen, 'departemen', 'departemen');

		$dataUnitbisnis = MsUnitBisnis::find()
			->select(['unit_bisnis'])
			->orderBy('unit_bisnis')
			->all();
		$listUnitbisnis = ArrayHelper::map($dataUnitbisnis, 'unit_bisnis', 'unit_bisnis');

		$dataLevel = MsLevel::find()
			->select(['level_jabatan'])
			->orderBy('level_jabatan')
			->all();
		$listLevel = ArrayHelper::map($dataLevel, 'level_jabatan', 'level_jabatan');

		if ($model->load(Yii::$app->request->post())) {
			$check = $this->findPeserta($model->kode_anggota, $model->keterangan);
			if ($check) {
				$model->addError('keterangan', 'Keterangan ini sudah digunakan.');
			} else {
				if ($model->keterangan == 'SUAMI/ISTRI') {
					if ($model->jenis_kelamin == 'P') {
						$model->keterangan = 'ISTRI';
					} else {
						$model->keterangan = 'SUAMI';
					}
				}
				if ($model->keterangan != 'PESERTA INDUK') {
					$dataInduk = $model->find()
						->select('departemen')
						->where("kode_anggota = '" . $model->kode_anggota . "'")
						->one();
					$model->departemen = $dataInduk->departemen;
				}

				$model->input_by = Yii::$app->user->identity->username;
				$model->input_date = date("Y-m-d H:i:s");
				if ($model->save()) {
					return $this->redirect(['view', 'id' => $model->id]);
				}
			}
		}
		return $this->render('create', [
			'model' => $model,
			'listDepartemen' => $listDepartemen,
			'listUnitbisnis' => $listUnitbisnis,
			'listLevel' => $listLevel
		]);
	}

	public function actionSync()
	{
		$model = new MsPeserta();
		$dataDepartemen = MsDepartemen::find()
			->select(['departemen'])
			->orderBy('departemen')
			->all();
		$listDepartemen = ArrayHelper::map($dataDepartemen, 'departemen', 'departemen');

		$dataUnitbisnis = MsUnitBisnis::find()
			->select(['unit_bisnis'])
			->orderBy('unit_bisnis')
			->all();
		$listUnitbisnis = ArrayHelper::map($dataUnitbisnis, 'unit_bisnis', 'unit_bisnis');

		$dataLevel = MsLevel::find()
			->select(['level_jabatan'])
			->orderBy('level_jabatan')
			->all();
		$listLevel = ArrayHelper::map($dataLevel, 'level_jabatan', 'level_jabatan');

		if ($model->load(Yii::$app->request->post())) {
			if ($model->tgl_lahir == "") {
				$model->addError('tgl_lahir', 'Tanggal lahir wajib diisi!');
			} else {
				$cek = $model->getPesertaAll($model->kode_anggota);
				if ($cek) {
					//update data peserta induk dan keluarga
					$newModel = $model->find()->where("kode_anggota = '" . $model->kode_anggota . "' and keterangan = 'PESERTA INDUK'")->one();
					$newModel->load(Yii::$app->request->post());
					$newModel->modi_by = Yii::$app->user->identity->username;
					$newModel->modi_date = date("Y-m-d H:i:s");
					//var_dump($newModel);exit;
					if ($newModel->save()) {
						$this->UpdateAnggota($newModel->id);
						return $this->redirect(['view', 'id' => $newModel->id]);
					}
				} else {

					//input data peserta induk
					$model->input_by = Yii::$app->user->identity->username;
					$model->input_date = date("Y-m-d H:i:s");
					if ($model->save()) {
						return $this->redirect(['view', 'id' => $model->id]);
					}
				}
			}
		}
		return $this->render('sync', [
			'model' => $model,
			'listDepartemen' => $listDepartemen,
			'listUnitbisnis' => $listUnitbisnis,
			'listLevel' => $listLevel
		]);
	}

	public function actionGetdatainduk()
	{
		$kd_anggota = Yii::$app->request->post('kd_anggota');
		$model = new MsPeserta();
		$dataInduk = $model->find()
			->select(['level_jabatan', 'departemen', 'unit_bisnis'])
			->where("kode_anggota = '" . $kd_anggota . "'")
			->one();
		return Json::encode($dataInduk);
	}

	public function actionGetdatasync()
	{
		$kd_anggota = Yii::$app->request->post('kd_anggota');
		$modelUB = new MsUnitBisnis();
		$modelLV = new MsLevel();
		$modelDP = new MsDepartemen();
		$modelhrd = new MsHRD();
		$data = $modelhrd->getDataPesertaFromKaryawan($kd_anggota);
		
		if ($data) {
			$res['kode_anggota'] = $data['nik'];
			$res['nama_peserta'] = $data['nama'];
			$res['jenis_kelamin'] = $data['kd_gender'];
			$res['tempat_lahir'] = $data['kota_lahir'];
			$res['tgl_lahir'] = date("Y-m-d", strtotime($data['tgl_lahir']));
			$res['alamat'] = $data['alamat'];
			$ub =  $modelUB->getDataByAlias($data['kd_cabang']);
			$lv =  $modelLV->getDataByAlias($data['kd_jabatan']);
			$dp =  $modelDP->getDataByAlias($data['kd_divisi']);
			$res['unit_bisnis'] = $ub['unit_bisnis'];
			if ($data['kd_cabang'] <> 'MD' && $data['kd_cabang'] <> 'SP') {
				$res['departemen'] = "CABANG";
			} else {
				$res['departemen'] = $dp['departemen'];
			}
			$res['level_jabatan'] = $lv['level_jabatan'];
			if ($data['kd_status_karyawan'] == 'STS-1' || $data['kd_status_karyawan'] == 'STS-2') {
				$res['active'] = 1;
			} else {
				$res['active'] = 0;
			}
		} else {
			$res = null;
		}

		return Json::encode($res);
	}

	/**
	 * Updates an existing MsPeserta model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		$dataDepartemen = MsDepartemen::find()
			->select(['departemen'])
			->orderBy('departemen')
			->all();
		$listDepartemen = ArrayHelper::map($dataDepartemen, 'departemen', 'departemen');

		$dataUnitbisnis = MsUnitBisnis::find()
			->select(['unit_bisnis'])
			->orderBy('unit_bisnis')
			->all();
		$listUnitbisnis = ArrayHelper::map($dataUnitbisnis, 'unit_bisnis', 'unit_bisnis');

		$dataLevel = MsLevel::find()
			->select(['level_jabatan'])
			->orderBy('level_jabatan')
			->all();
		$listLevel = ArrayHelper::map($dataLevel, 'level_jabatan', 'level_jabatan');

		if ($model->load(Yii::$app->request->post())) {
			if ($model->keterangan == 'SUAMI/ISTRI') {
				if ($model->jenis_kelamin == 'P') {
					$model->keterangan = 'ISTRI';
				} else {
					$model->keterangan = 'SUAMI';
				}
			}
			// if ($model->keterangan != 'PESERTA INDUK') {
			// 	$dataInduk = $model->find()
			// 		->select('departemen, level_jabatan, unit_bisnis, alamat')
			// 		->where("kode_anggota = '" . $model->kode_anggota . "' and keterangan = 'PESERTA INDUK'")
			// 		->one();
			// 	$model->departemen = $dataInduk->departemen;
			// 	$model->level_jabatan = $dataInduk->level_jabatan;
			// 	$model->unit_bisnis = $dataInduk->unit_bisnis;
			// 	$model->alamat = $dataInduk->alamat;
			// }

			$model->modi_by = Yii::$app->user->identity->username;
			$model->modi_date = date("Y-m-d H:i:s");

			if ($model->save()) {
				if ($model->keterangan == 'PESERTA INDUK') {
					$this->UpdateAnggota($id);
				}
				return $this->redirect(['view', 'id' => $model->id]);
			}
			// }
		}

		// if ($model->load(Yii::$app->request->post()) && $model->save()) {
		// return $this->redirect(['view', 'id' => $model->id]);
		// }

		return $this->render('update', [
			'model' => $model,
			'listDepartemen' => $listDepartemen,
			'listUnitbisnis' => $listUnitbisnis,
			'listLevel' => $listLevel
		]);
	}

	public function UpdateAnggota($id)
	{
		$dataInduk = $this->findModel($id);
		$dataPeserta = $this->findAnggota($dataInduk->kode_anggota);
		if ($dataPeserta) {
			foreach ($dataPeserta as $da) {
				if ($da->keterangan != "PESERTA INDUK") {
					$model = $this->findModel($da->id);
					$model->alamat = $dataInduk->alamat;
					$model->level_jabatan = $dataInduk->level_jabatan;
					$model->departemen = $dataInduk->departemen;
					$model->unit_bisnis = $dataInduk->unit_bisnis;
					$model->modi_by = Yii::$app->user->identity->username;
					$model->modi_date = date("Y-m-d H:i:s");
					$model->save();
				}
			}
		}
		//
	}

	/**
	 * Deletes an existing MsPeserta model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionDelete($id)
	{
		$this->findModel($id)->delete();

		return $this->redirect(['index']);
	}

	public function actionCetakkartu($kode_anggota)
	{
		$model = new MsPeserta();

		$data = $model->getPesertaAll($kode_anggota);

		return $this->render('kartu', [
			'data' => $data,
			'kode_anggota' => $kode_anggota
		]);
	}

	/**
	 * Finds the MsPeserta model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return MsPeserta the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = MsPeserta::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}

	protected function findPeserta($kode_anggota, $keterangan)
	{
		if (($model = MsPeserta::find()->where(['kode_anggota' => $kode_anggota])->andWhere(['keterangan' => $keterangan])->andWhere(['active' => '1'])->one()) !== null) {
			return true;
		}
		return false;
	}

	protected function findAnggota($kode_anggota)
	{
		if (($model = MsPeserta::find()->where(['kode_anggota' => $kode_anggota])->andWhere(['active' => '1'])->all()) !== null) {
			return $model;
		}
		return false;
	}

	public function actionPrintkartu($kode_anggota)
	{

		$model = new MsPeserta();
		$data = $model->getPesertaAll($kode_anggota);

		$content = $this->renderPartial('kartu', [
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
			// set mPDF properties on the fly
			//'options' => ['title' => 'Cetak Kartu Tricare'],
			// call mPDF methods on the fly
			'methods' => [
				'SetTitle' => ['Cetak Kartu Tricare'],
				'SetHeader' => ['Kartu Tricare'],
				'SetFooter' => ['{PAGENO}'],
			]
		]);

		// return the pdf output as per the destination setting
		//$pdf->Text(10,10,"test");
		return $pdf->render();
	}

	public function actionIndexnonaktifpeserta($proses = null)
	{
		$searchModel = new Mspeserta();
        $listData = $searchModel->listPesertaNonAktif();

		return $this->render('indexnonaktifpeserta', [
			'listData' => $listData,
			'proses' => $proses
		]);
	}

	public function actionSyncnonaktifpeserta()
    {
        $selectedItems = Yii::$app->request->post('selectedItems');
        
        $transaction = Yii::$app->db->beginTransaction();
        
        try {
            if (!empty($selectedItems)) {
                foreach ($selectedItems as $selectedKodeanggota) {
                    $model = MsPeserta::findOne(['kode_anggota' => $selectedKodeanggota]);
                    if ($model) {
						$model->modi_by = Yii::$app->user->identity->username;
						$model->modi_date = date("Y-m-d H:i:s");
                        $model->active = 0;
                        if (!$model->save()) {
							$transaction->rollBack();
                            $errorMessage = 'Gagal nonaktifkan peserta: ' . print_r($model->getErrors(), true);
							Yii::error($errorMessage);
							throw new \Exception($errorMessage);
                        }else{
							$model_user = User::findOne(['username' => $selectedKodeanggota]);
							if ($model_user) {
								$model_user->modi_by = Yii::$app->user->identity->username;
								$model_user->modi_date = date("Y-m-d H:i:s");
								$model_user->active = 0;
								if (!$model_user->save()) {
									$transaction->rollBack();
									$errorMessage = 'Gagal nonaktifkan user: ' . print_r($model_user->getErrors(), true);
									Yii::error($errorMessage);
									throw new \Exception($errorMessage);
								}
							}
						}
                    }
                }

				$transaction->commit();
            	Yii::$app->session->setFlash('success', 'Peserta Berhasil Dinonaktifkan.');
            }else{
				$transaction->rollBack();
            	Yii::$app->session->setFlash('error', 'Tidak Ada Data yang Dipilih');
			}
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::$app->session->setFlash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
        
        return $this->redirect(['indexnonaktifpeserta', 'proses' => 'nonaktif']);
    }
}
