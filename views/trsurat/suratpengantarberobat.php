<?php


use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\BaseUrl;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */


//$this->title = 'Cetak Kartu - '.$kode_anggota;
//$this->params['breadcrumbs'][] = $this->title;
$jmldata = 0;
$jk = "";
?>
<div id="maindiv">
    <img src="<?= Yii::$app->request->baseUrl . "/images/logo-trio-300x100.png" ?>" height="70"><br /><br />
    <div id="divpage" style="margin-left:600px; margin-bottom: -21px">Page 1 of 1</div>
    <div id="divtable0">
        <table id="tableheader" style="border:1px solid black;border-collapse:collapse">
            <tr>
                <td colspan="4" style="text-align:center;border:1px solid black;">Surat Keterangan</td>
            </tr>
            <tr>
                <td style="border:1px solid black;">Kode Surat</td>
                <td style="border:1px solid black;"><?= $data->no_surat ?></td>
                <td style="border:1px solid black;">Tanggal Surat</td>
                <td style="border:1px solid black;"><?= $tglSurat ?></td>
            </tr>
            <tr>
                <td style="border:1px solid black;">Dicetak Oleh</td>
                <td style="border:1px solid black;"><?= Yii::$app->user->identity->username ?></td>
                <td style="border:1px solid black;">Tanggal Cetak</td>
                <td style="border:1px solid black;"><?= $data->tgl_kuitansi ?></td>
            </tr>
        </table>
    </div>
    <br />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dengan ini kami yang bertanda tangan dibawah ini menerangkan bahwa nama berikut adalah benar-benar karyawan kami sebagai berikut :<br /><br />
    <div id="divtable1">
        <table>
            <tr>
                <td width="120px">Kode Anggota</td>
                <td>:</td>
                <td><?= $datainduk->kode_anggota ?></td>
            </tr>
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td><?= $datainduk->nama_peserta ?></td>
            </tr>
            <tr>
                <td>Perusahaan</td>
                <td>:</td>
                <td><?= $datainduk->unit_bisnis ?></td>
            </tr>
            <tr>
                <td>Departemen</td>
                <td>:</td>
                <td><?= $datainduk->departemen ?></td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>:</td>
                <td><?= $datainduk->level_jabatan ?></td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td><?= $datainduk->alamat ?></td>
            </tr>
        </table>
    </div>
    <br />Maksud dan Keperluan :<br />
    <div id="divtable2">
        <table>
            <tr>
                <td width="200px">Pengantar Berobat untuk</td>
                <td>:</td>
                <td><?= $data->nama_peserta ?></td>
            </tr>
            <tr>
                <td>Masa Berlaku</td>
                <td>:</td>
                <td><?= $masaberlaku ?></td>
            </tr>
        </table>
    </div><br />
    Demikianlah Surat Keterangan ini kami buat dan untuk digunakan dengan sebagaimana mestinya. Atas perhatian anda kami ucapkan terima kasih.<br />
    <br />
    Banjarmasin, <?= $tglSurat ?><br />
    Dibuat Oleh,<br /><br /><br />
    <?= $data->nama_pengurus ?>
    <hr style="color:black; width:180px; margin:-0px;text-align:left">
    <?= $data->jabatan ?>
    <br /><br /><br /><br />
    <i>
        <b>Note :</b><br />
        *Kartu terbaru belum terbit karena <b>penambahan tanggungan</b><br />
        **Jika kartu terbaru sudah ada maka surat ini tidak berlaku
    </i>
</div>