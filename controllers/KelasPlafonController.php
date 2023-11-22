<?php  

namespace app\controllers;

use Yii;
use yii\web\Controller;

class KelasPlafonController extends Controller
{

	public $layout = 'provider';

	public function actionIndex()
	{
		if (Yii::$app->user->isGuest) {
			return $this->redirect(array('/provider/login'));
		} elseif(Yii::$app->user->identity->id_provider == null) {
			return $this->redirect(array('/provider/logout'));
		}

		if (isset($_GET['kode_anggota'])) {
			// Mendapatkan Data Peserta Induk
			$peserta = (new yii\db\Query())
			->select(['ms_peserta.nama_peserta', 'ms_peserta.kode_anggota', 'ms_peserta.level_jabatan', 'ms_peserta.id'])
			->from('ms_peserta')
			->where(['ms_peserta.keterangan' => 'PESERTA INDUK'])
			->where(['ms_peserta.kode_anggota' => $_GET['kode_anggota']])
			->one();

			if ($peserta) {
				// Mendapatkan Data Hak Kelas Berdasarkan Level Peserta
				$hak_kelas = (new yii\db\Query())
				->select(["*"])
				->from('ms_plafon')
				->where(['level' => $peserta['level_jabatan']])
				->all();

			// Mendapatkan Data Jumlah Anggota Peserta
				$jumlah_anggota = (new yii\db\Query())
				->from('ms_peserta')
				->where(['kode_anggota' => $peserta["kode_anggota"]])
				->count();
				$year = date("Y");
				$data_plafon = (new yii\db\Query())
				->select(["tr_plafon.nama_plafon", "SUM(tr_plafon.biaya) AS total_biaya"])
				->from("tr_plafon")
				->join("INNER JOIN", 'ms_peserta', 'ms_peserta.id = tr_plafon.id_peserta')
				->where(["ms_peserta.kode_anggota" => $peserta["kode_anggota"]])
				->andWhere(['YEAR(tr_plafon.tanggal)' => $year])
				->groupBy(["tr_plafon.nama_plafon"])
				->all();
			} else {
				$peserta = [];
				$hak_kelas = [];
				$jumlah_anggota = 0;
				$data_plafon = [];
			}

		} else {
			$peserta = [];
			$hak_kelas = [];
			$jumlah_anggota = 0;
			$data_plafon = [];
		}

		return $this->render('index', [
			"peserta" => $peserta,
			"hak_kelas" => $hak_kelas,
			"jumlah_anggota" => $jumlah_anggota,
			"data_plafon" => $data_plafon
		]);
	}
}