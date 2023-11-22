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
    <img src="<?= Yii::$app->request->baseUrl . "/images/logohonda.png" ?>" height="20"><br /><br /><br />
    <div align="center"><b><u>SURAT KETERANGAN KLAIM REJECT</u></b></div>
    <div align="center">No : <?= $data->no_surat ?></div><br />
    <div style="color:red"><b>Salam Satu HATI,</b></div>
    Berikut ini kami beritahukan bahwa :<br />
    <div id="divtable1">
        <table>
            <tr>
                <td>Nama Karyawan</td>
                <td>:</td>
                <td><?= $datainduk->nama_peserta ?></td>
            </tr>
            <tr>
                <td>Nama Pasien</td>
                <td>:</td>
                <td><?= $data->nama_peserta ?></td>
            </tr>
            <tr>
                <td>Badan Usaha/Dept</td>
                <td>:</td>
                <td><?= $datainduk->unit_bisnis ?> / <?= $datainduk->departemen ?></td>
            </tr>
            <tr>
                <td>Tanggal Kuitansi</td>
                <td>:</td>
                <td><?= $data->tgl_kuitansi ?></td>
            </tr>
            <tr>
                <td>Tanggal Diterima Claim</td>
                <td>:</td>
                <td><?= $data->tgl_terimaclaim ?></td>
            </tr>
        </table>
    </div><br />
    Untuk claim tricare tersebut <u><b>REJECT</b></u> dengan alasan sebagai berikut :<br /><br />
    <div id="divtable2">
        <table id="tabledetail">
            <tr>
                <th>Keterangan Klaim Reject</th>
                <th>Nominal Uang</th>
                <th>Informasi Medis/Keluhan pada Form Tricare</th>
            </tr>
            <tr>
                <td><?= $data->keterangan_reject ?></td>
                <td>Rp. <?=  number_format($data->nominal_reject, 0, ',', '.') ?></td>
                <td><?= $data->informasi_sakit ?></td>
            </tr>
        </table>
    </div>
    <br />
    Demikian yang dapat kami sampaikan agar dikemudian harinya dapat menjadi maklum. Atas perhatiannya kami ucapkan terima kasih.
    <br />
    <br />
    Banjarmasin, <?= $tglSurat ?><br />
    <table style="width:100%;margin-left:-3px">
        <tr >
            <td height="80px" width="50%">Membuat,</td>
            <td>Mengetahui/Menyetujui,</td>
        </tr>
        <tr>
            <td><?= $data->nama_pengurus ?></td>
            <td><?= $mengetahui ?></td>
        </tr>
    </table>
    
</div>