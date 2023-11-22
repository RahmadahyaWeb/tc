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
    <img src="<?=  Yii::$app->request->baseUrl."/images/logohonda.png" ?>" height="20"><br /><br />
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
    <div text-align="center" align="center"><b><u>SURAT JAMINAN RAWAT INAP</u></b></div><br />
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
                <td>Informasi Sakit</td>
                <td>:</td>
                <td><?= $data->informasi_sakit ?></td>
            </tr>
        </table>
    </div><br />
    Memberikan jaminan untuk pelayanan kesehatan Peserta TRICARE dengan fasilitas dan pelayanan sebagai berikut :<br />
    <ul>
        <li>Biaya kamar max. Rp. <?= $thisdata->plafonkamar ?> / Hari, Kunjungan Dokter Rp. <?= $thisdata->plafonkunjungan ?> / Hari.</li>
        <li>Rawat Inap yang ditanggung Max. <?= $thisdata->sisahari ?> hari.</li>
        <li>Unit Gawat Darurat, Pemeriksaan Laboratorium, Rontgen, USG dan Radiologi.</li>
        <li>Kategori jaminan kecelakaan ditanggung maksimal Rp. <?= $thisdata->plafonkecelakaan ?> / kejadian dengan syarat tertentu.</li>
        <li>Plafon Rawat Inap yang ditanggung maksimal Rp. <?= $thisdata->sisaplafoninap ?>.</li>
        <li>Pembedahan diluar akibat dari kecelakaan kerja atau kecelakaan lalu lintas diberikan pergantian antara lain Pembedahan Kecil Rp. <?= $thisdata->plafonbedahkecil ?>, Pembedahan Sedang Rp. <?= $thisdata->plafonbedahsedang ?> dan Pembedahan Besar Rp. <?= $thisdata->plafonbedahbesar ?>.</li>
        <li>Kategori pembedahan merujuk pada hasil diagnosa dokter. Dalam hal ini pergantian biaya pembehahan ini dengan sistem paket sesuai dengan jenis pembedahan yang dilakukan. Pergantian termasuk biaya : dokter, bedah, anestesi, kamar operasi, peralatan dan obat-obatan penunjang pembedahan.</li>
        <li>Pada kasus pembedahan yang dilakukan pasca operasi biaya dihitung berdasarkan paket pembedahan dan ditambahkan dengan tanggungan rawat inap.</li>
        <li>CT Scan Rp. <?= $thisdata->plafonctscan ?> / tahun pada rawat inap diluar dari plafon karyawan.</li>
        <li>Apabila terdapat selisih atau tidak sesuai dari yang dijamin <b>TRICARE</b>, maka pihak Rumah Sakit <b>wajib</b> meminta langsung kepada pasien sebelum pasien tersebut keluar dari Rumah Sakit.</li>
        <li>Bagi yang melakukan klaim ke asuransi, yang dapat diklaim adalah selisih dari biaya yang tidak di <i>cover</i> asuransi dengan mengikuti ketentuan <i>benefit</i> <b>TRICARE</b>.</li>
        <li><b>Jika ada pelayanan COVID-19 di Rumah Sakit, untuk biaya tersebut WAJIB ditagihkan ke pasien</b>.</li>
    </ul>
    Demikianlah Surat Jaminan Rawat Inap ini diberikan agar dapat digunakan sebagaimana mestinya. Atas kerjasamanya kami ucapkan terima kasih.<br />
    <br />
    Banjarmasin, <?= $tglSurat ?><br />
    Hormat kami,<br /><br /><br />
    <?= $data->nama_pengurus ?><hr style="color:black; width:180px; margin:-0px;text-align:left">
    <?= $data->jabatan ?><br /><br />
    <img src="<?=  Yii::$app->request->baseUrl."/images/logofooter.png" ?>" height="130">
</div>