<?php

namespace app\controllers;

use app\models\MsJenisplafon;
use app\models\MsPeserta;
use app\models\MsPlafon;
use app\models\MsPlafonextend;
use app\models\TrPlafon;
use app\models\TrPlafonOver;
use app\models\TrPlafonOverSearch;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class TrplafonOverController extends Controller
{
    public function checkuser()
    {
        if (Yii::$app->user->identity->user_group != 'admin') {
            return $this->goHome();
        }
    }

    public function actionIndex()
    {
        if (!isset(Yii::$app->user->identity->username)) {
            return $this->redirect(['/site/login']);
        }

        $data = Yii::$app->request->post();

        $searchModel = new TrPlafonOverSearch();
        $searchModel->tanggal = date("Y");
        $searchModel->nama_plafon = isset($data['nama_plafon']) ? $data['nama_plafon'] : "";
        $kodeAnggota = isset($data['kode_anggota']) ? $data['kode_anggota'] : "";
        $namaPeserta = isset($data['nama_peserta']) ? $data['nama_peserta'] : "";

        $dataProvider = $searchModel->search($data, $kodeAnggota, $namaPeserta);
        $dataPlafon = MsJenisplafon::find()
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

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'listPlafon' => $listPlafon,
            'listTahun' => $listTahun,
            'data' => $data
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionUpdate($id)
    {

        $model = $this->findModel($id);

        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            if ($model->load($data)) {
                $model->status = $data['TrPlafonOver']['status'];
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', "Data Berhasil Disimpan");
                    return json_encode([
                        'success' => true,
                        'message' => 'Data berhasil disimpan!'
                    ]);
                } else {
                    return json_encode([
                        'errors' => $model->getErrors()
                    ]);
                }
            }
        }


        $tahun = substr($model->tanggal, 0, 4);
        $query_tahun = " left(tanggal,4) = '" . $tahun . "'";

        $jatahPlafon = $this->plafonCukup($model->id_peserta, $model->nama_plafon, 0, 0, $tahun);

        $dataPeserta = (new Yii\db\Query())
            ->select(['kode_anggota'])
            ->from('ms_peserta')
            ->where([
                'id' => $model->id_peserta
            ])
            ->one();

        $dataOver = (new Yii\db\Query())
            ->select(['*'])
            ->from('tr_plafon_over')
            ->join('LEFT JOIN', 'ms_peserta', 'ms_peserta.id = tr_plafon_over.id_peserta')
            ->join('LEFT JOIN', 'ms_provider', 'ms_provider.id = tr_plafon_over.id_provider')
            ->where([
                'tr_plafon_over.kode_anggota' => $dataPeserta['kode_anggota'],
                'tr_plafon_over.nama_plafon' => $model->nama_plafon,
            ])
            ->andWhere($query_tahun)
            ->andWhere('tr_plafon_over.biaya > 0')
            ->all();

        $subquery = (new Yii\db\Query())
            ->select('id')
            ->from('ms_peserta')
            ->where(['kode_anggota' => $dataPeserta['kode_anggota']]);

        $totalBiayaOver =  (new Yii\db\Query())
            ->select(['SUM(tr_plafon_over.biaya) AS total_biaya'])
            ->from('tr_plafon_over')
            ->where([
                'tr_plafon_over.id_peserta' => $subquery,
                'tr_plafon_over.nama_plafon' => $model->nama_plafon,
            ])
            ->andWhere($query_tahun)
            ->one();

        $totalBiayaPlafon =  (new Yii\db\Query())
            ->select(['SUM(tr_plafon.biaya_inputan) AS total_biaya'])
            ->from('tr_plafon')
            ->where([
                'tr_plafon.id_peserta' => $subquery,
                'tr_plafon.nama_plafon' => $model->nama_plafon,
                'tr_plafon.nonbenefit' => NULL
            ])
            ->andWhere($query_tahun)
            ->one();

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
            'dataOver' => $dataOver,
            'totalBiayaOver' => $totalBiayaOver,
            'totalBiayaPlafon' => $totalBiayaPlafon,
            'listStatusBayar' => $listStatusBayar,
            'jatahPlafon' => $jatahPlafon
        ]);
    }

    protected function findModel($id)
    {
        $model = TrPlafonOver::find()
            ->joinWith(['peserta'])
            ->joinWith(['provider'])
            ->where(['tr_plafon_over.id' => $id])
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
}
