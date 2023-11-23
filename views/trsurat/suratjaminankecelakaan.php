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
    <img src="../TRICARE/images/logohonda.png" height="20"><br /><br />
    <div id="divtable0">
        <table>
            <tr>
                <td width="50px">No</td>
                <td>:</td>
                <td><?= $data->no_surat ?></td>
            </tr>
            <tr>
                <td>Hal</td>
                <td>:</td>
                <td>Surat Jaminan</td>
            </tr>
        </table>
    </div>
    <br />
    Kepada :<br />
    <b><?= $data->tujuan_surat ?></b><br />
    <b><?= $data->up_surat ?></b><br />
    Di - Tempat<br />
    <div text-align="center" align="center"><b><u>SURAT JAMINAN KECELAKAAN</u></b></div><br />
    Yang bertanda tangan dibawah ini :<br />
    <div id="divtable1">
        <table>
            <tr>
                <td width="150px">Nama</td>
                <td>:</td>
                <td><?= $data->nama_pengurus ?></td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>:</td>
                <td><?= $data->jabatan ?></td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td><?= $data->alamat ?></td>
            </tr>
        </table>
    </div>
    Dengan ini menerangkan bahwa :<br />
    <div id="divtable2">
        <table>
            <tr>
                <td width="150px">Nama</td>
                <td>:</td>
                <td><?= $data->nama_peserta ?></td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td><?= $data->alamat_peserta ?></td>
            </tr>
            <tr>
                <td>No. Anggota</td>
                <td>:</td>
                <td><?= $data->kode_anggota ?></td>
            </tr>
            <tr>
                <td>Keterangan</td>
                <td>:</td>
                <td><?= $data->informasi_sakit ?></td>
            </tr>
        </table>
    </div><br />
    Memberikan jaminan untuk pelayanan kesehatan peserta <b>TRICARE</b> dengan fasilitas pelayanan sebagai berikut :<br />
    <ul>
        <li>Kategori jaminan kecelakaan ditanggung maksimal Rp <?= $thisdata->plafonkecelakaan ?> / kejadian, dengan syarat tertentu.</li>
        <li>Perusahaan menanggung seluruh biaya pengobatan peserta Tricare.</li>
        <li>Selama pengobatan tersebut masuk dalam kategori indikasi medis dokter, biaya menjadi tanggungan perusahaan.</li>
        <li>Apabila terdapat selisih atau tidak sesuai dari yang dijamin <b>TRICARE</b>, maka pihak Rumah Sakit <b>wajib</b> meminta langsung kepada pasien sebelum pasien tersebut keluar dari Rumah Sakit.</li>
    </ul>
    Demikianlah Surat Jaminan Kecelakaan ini diberikan agar dapat digunakan sebagaimana mestinya. Atas kerjasamanya kami ucapkan terima kasih.<br />
    <br />
    Banjarmasin, <?= $tglSurat ?><br />
    Hormat kami,<br /><br /><br />
    <?= $data->nama_pengurus ?><hr style="color:black; width:180px; margin:-0px;text-align:left">
    <?= $data->jabatan ?><br /><br />
    <img src="../TRICARE/images/logofooter.png" height="130">
</div>