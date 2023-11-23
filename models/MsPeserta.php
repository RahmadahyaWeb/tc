<?php

namespace app\models;

use yii\helpers\ArrayHelper;

use Yii;

/**
 * This is the model class for table "ms_peserta".
 *
 * @property int $id
 * @property string $kode_anggota
 * @property string $nama_peserta
 * @property string $keterangan
 * @property string $jenis_kelamin
 * @property string $tempat_lahir
 * @property string $tgl_lahir
 * @property string $level_jabatan
 * @property string $input_by
 * @property string $input_date
 * @property string|null $modi_by
 * @property string|null $modi_date
 */
class MsPeserta extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'ms_peserta';
	}

	public $daftar;
	public $jmlanggota;
	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['alamat', 'kode_anggota', 'nama_peserta', 'keterangan', 'jenis_kelamin', 'tempat_lahir', 'tgl_lahir', 'level_jabatan', 'departemen', 'unit_bisnis', 'input_by', 'active'], 'required'],
			[['tgl_lahir'], 'safe'],
			[['kode_anggota', 'input_by', 'modi_by'], 'string', 'max' => 20],
			[['nama_peserta', 'tempat_lahir'], 'string', 'max' => 100],
			[['keterangan'], 'string', 'max' => 13],
			[['jenis_kelamin'], 'string', 'max' => 1],
			[['level_jabatan'], 'string', 'max' => 50],
			[['alamat'], 'string', 'max' => 200],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'kode_anggota' => 'Kode Anggota',
			'nama_peserta' => 'Nama Peserta',
			'keterangan' => 'Keterangan',
			'jenis_kelamin' => 'Jenis Kelamin',
			'tempat_lahir' => 'Tempat Lahir',
			'tgl_lahir' => 'Tgl Lahir',
			'level_jabatan' => 'Level Jabatan',
			'divisi' => 'Divisi',
			'input_by' => 'Input By',
			'input_date' => 'Input Date',
			'modi_by' => 'Modi By',
			'modi_date' => 'Modi Date',
			'active' => 'Status',
			'departemen' => 'Departemen',
			'unit_bisnis' => 'Unit Bisnis',
			'alamat' => 'Alamat',
		];
	}

	public function listGender()
	{
		$gender = [
			1 => [
				'code' => 'L',
				'name' => 'Laki-laki'
			],
			2 => [
				'code' => 'P',
				'name' => 'Perempuan'
			]
		];
		return $gender;
	}

	public function listKeterangan()
	{
		$jabatan = [
			1 => [
				'code' => 'PESERTA INDUK',
				'name' => 'Peserta Induk'
			],
			2 => [
				'code' => 'SUAMI/ISTRI',
				'name' => 'Suami/Istri'
			],
			3 => [
				'code' => 'ANAK 1',
				'name' => 'Anak 1'
			],
			4 => [
				'code' => 'ANAK 2',
				'name' => 'Anak 2'
			],
			5 => [
				'code' => 'ANAK 3',
				'name' => 'Anak 3'
			]
		];
		return $jabatan;
	}

	public function listStatus()
	{
		$sts = [
			1 => [
				'code' => '1',
				'name' => 'Aktif'
			],
			2 => [
				'code' => '0',
				'name' => 'Non Aktif'
			]
		];
		return $sts;
	}

	public function listPeserta()
	{
		$dataPeserta = self::find()
		->select(['id', 'kode_anggota', 'nama_peserta', 'CONCAT(TRIM(kode_anggota), \' - \', nama_peserta) AS daftar'])
		->where([
			'active' => 1,
		])
		->orderBy('kode_anggota')
		->all();
		$data = ArrayHelper::map($dataPeserta, 'id', 'daftar');
		return $data;
	}

	public function getPesertaInduk($kode_anggota)
	{
		$data = self::find()->where("kode_anggota = '" . $kode_anggota . "' and keterangan= 'PESERTA INDUK' and active = 1")->one();
		return $data;
	}

	public function getPesertaIndukAll($kode_anggota)
	{
		$data = self::find()->where("kode_anggota = '" . $kode_anggota . "' and keterangan= 'PESERTA INDUK' and active = 1")->All();
		return $data;
	}

	public function getPesertaAnggota($kode_anggota)
	{
		$data = self::find()->where("kode_anggota = '" . $kode_anggota . "' and keterangan <> 'PESERTA INDUK' and active = 1")->All();
		return $data;
	}

	public function getPesertaAll($kode_anggota)
	{
		$data = self::find()->where("kode_anggota = '" . $kode_anggota . "' and active = 1")->All();
		return $data;
	}

	public function getJumlahAnggota($kode_anggota)
	{
		$data = self::find()->select("count(1) as jmlanggota")->where("kode_anggota = '" . $kode_anggota . "' and active = 1")->one();
		return $data['jmlanggota'];
	}

	public function listPesertaNonAktif()
	{
		$modelhrd = new MsHRD();
		$dataProvider = $modelhrd->getDataKaryawanNonAktif();

		$nikArray = array_column($dataProvider, 'nik');
		$nikString = implode("', '", $nikArray);

		$data = self::find()->where("kode_anggota in ('" . $nikString . "') and active = 1")->All();

		$newDataArray = [];

		foreach ($data as $item) {
			if (!empty($item->kode_anggota)) {
				$newDataArray[$item->kode_anggota] = [
					'kode_anggota' => $item->kode_anggota,
					'nama_peserta' => $item->nama_peserta,
					'unit_bisnis' => $item->unit_bisnis,
					'nama' => '',
					'nama_cabang' => '',
					'tgl_keluar' => '',
				];
			}
		}

		foreach ($dataProvider as $item) {
			if (isset($newDataArray[$item->nik])) {
				$newDataArray[$item->nik]['nik'] = $item->nik;
				$newDataArray[$item->nik]['nama'] = $item->nama;
				$newDataArray[$item->nik]['nama_cabang'] = $item->kd_cabang;
				$newDataArray[$item->nik]['tgl_keluar'] = $item->tgl_keluar;
			}
		}

		usort($newDataArray, function ($a, $b) {
			return strtotime($a['tgl_keluar']) - strtotime($b['tgl_keluar']);
		});

		$newDataArray = array_values($newDataArray);

		return $newDataArray;
	}
}
