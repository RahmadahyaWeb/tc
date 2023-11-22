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
    <img src="<?= Yii::$app->request->baseUrl . "/images/logohonda.png" ?>" height="20"><br /><br />
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
    <div text-align="center" align="center"><b><u>SURAT JAMINAN MELAHIRKAN</u></b></div><br />
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
    Memberikan jaminan melahirkan dengan biaya yang ditanggung TRICARE sebesar :<br />
    <ul>
        <li>Persalinan dengan bantuan Bidan ditanggung max Rp <?= $thisdata->plafonpersalinanbidan ?>,- (<?= $thisdata->t_plafonpersalinanbidan ?>) untuk biaya persalinan, perawatan ibu & bayi.</li>
        <li>Persalinan dengan bantuan Dokter (Normal) ditanggung max Rp <?= $thisdata->plafonpersalinandokternormal ?>,- (<?= $thisdata->t_plafonpersalinandokternormal ?>) untuk biaya persalinan, perawatan ibu & bayi.</li>
        <li>Persalinan dengan bantuan Dokter (Caesar) ditanggung maksimal Rp <?= $thisdata->plafonpersalinandoktercesar ?>,- (<?= $thisdata->t_plafonpersalinandoktercesar ?>) untuk biaya persalinan, perawatan ibu & bayi.</li>
        <li>Persalinan diluar kandungan (Laparatomy) ditanggung max Rp <?= $thisdata->plafonpersalinanektopik ?>,- (<?= $thisdata->t_plafonpersalinanektopik ?>) untuk biaya persalinan dan perawatan ibu.</li>
        <li>Biaya vakum aspirasi/kuret ditanggung max Rp <?= $thisdata->plafonkuret ?>,- (<?= $thisdata->t_plafonkuret ?>)</li>
        <li>Plafon persalinan diatas dengan system paket, sudah termasuk semua biaya yang timbul akibat persalinan.</li>
        <li>Apabila ada keselisihan biaya, termasuk untuk biaya administrasi, maka Pihak Rumah Sakit wajib menagihkannya langsung kepada pasien sebelum pasien keluar dari Rumah Sakit.</li>
        <li>Untuk biaya pelayanan COVID-19 tidak menjadi tanggungan Tricare.</li>
    </ul>
    Demikianlah Surat Jaminan Melahirkan ini diberikan agar dapat digunakan sebagaimana mestinya. Atas kerjasamanya kami ucapkan terima kasih.<br />
    <br />
    Banjarmasin, <?= $tglSurat ?><br />
    Hormat kami,<br /><br /><br />
    <?= $data->nama_pengurus ?><hr style="color:black; width:180px; margin:-0px;text-align:left">
    <?= $data->jabatan ?><br /><br />
    <img src="<?= Yii::$app->request->baseUrl . "/images/logofooter.png" ?>" height="130">
</div>