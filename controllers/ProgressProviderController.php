<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\MsPeserta;
use app\models\TrProgress;
use yii\data\Pagination;


class ProgressProviderController extends Controller
{
	public $layout = 'provider';

	public function actionIndex()
	{

		if (Yii::$app->user->isGuest) {
			return $this->redirect(array('/provider/login'));
		} elseif(Yii::$app->user->identity->id_provider == null) {
			return $this->redirect(array('/provider/logout'));
		}

		// Ambil data id_provider dari user yang login
		$id_provider = Yii::$app->user->identity->id_provider;

		if (isset($_GET['resi'])) {
			$resi = $_GET['resi'];
			$query = (new \yii\db\Query())
			->select([
				"tr_progress_provider.resi",
				"ms_provider.nama",
				"tr_progress_provider.nominal_tagihan",
				"tr_progress_provider.tanggal_pembuatan_invoice",
				"tr_progress_provider.tanggal_penerimaan_invoice",
				"tr_progress_provider.tanggal_verifikasi_validasi_invoice",
				"tr_progress_provider.tanggal_pembayaran_invoice",
				"tr_progress_provider.id_provider",
				"tr_progress_provider.no_invoice"
			])
			->from("tr_progress_provider")
			->join("INNER JOIN", "ms_provider", "ms_provider.id = tr_progress_provider.id_provider")
			->where([
				"tr_progress_provider.id_provider" => $id_provider,
				"tr_progress_provider.resi"		   => $resi
			])
			->groupBy("tr_progress_provider.resi")
			->orderBy("tr_progress_provider.tanggal_pembuatan_invoice");
			

		} else {
			$query = (new \yii\db\Query())
			->select([
				"tr_progress_provider.resi",
				"ms_provider.nama",
				"tr_progress_provider.nominal_tagihan",
				"tr_progress_provider.tanggal_pembuatan_invoice",
				"tr_progress_provider.tanggal_penerimaan_invoice",
				"tr_progress_provider.tanggal_verifikasi_validasi_invoice",
				"tr_progress_provider.tanggal_pembayaran_invoice",
				"tr_progress_provider.id_provider",
				"tr_progress_provider.no_invoice"
			])
			->from("tr_progress_provider")
			->join("INNER JOIN", "ms_provider", "ms_provider.id = tr_progress_provider.id_provider")
			->where(["tr_progress_provider.id_provider" => $id_provider])
			->groupBy("tr_progress_provider.resi")
			->orderBy("tr_progress_provider.tanggal_pembuatan_invoice DESC");
		}

		$pagination = new \yii\data\Pagination([
			'totalCount' => $query->count(),
			'pageSize' => 3, // Number of items per page
		]);

		$query->offset($pagination->offset)
		->limit($pagination->limit);

		$results = $query->all();

		return $this->render('index', [
			'results' 		=> $results,
			'pagination' 	=> $pagination,
			'id_provider' 	=> $id_provider
		]);
	}
}