<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Non Aktif Peserta';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ms-peserta-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Proses', ['mspeserta/indexnonaktifpeserta', 'proses' => 'nonaktif'], ['class' => 'btn btn-info', 'style' => 'width: 150px; color: black; font-weight: bold;']) ?>
    </p>
    <div class="table-responsive"> 
        <table class="table table-striped table-bordered" style="table-layout: auto; width: auto;">
            <thead>
                <tr>
                    <th class="text-center" style="vertical-align: middle;">No.</th>
                    <th class="text-center" style="vertical-align: middle;">Kode Anggota</th>
                    <th class="text-center" style="vertical-align: middle;">Nama Peserta di<br>Aplikasi My Tricare</th>
                    <th class="text-center" style="vertical-align: middle;">Badan Usaha di<br>Aplikasi My Tricare</th>
                    <th class="text-center" style="vertical-align: middle;">Nama Karyawan di<br>Aplikasi HRD</th>
                    <th class="text-center" style="vertical-align: middle;">Badan Usaha di<br>Aplikasi HRD</th>
                    <th class="text-center" style="vertical-align: middle;">Tgl Berhenti</th>
                    <th class="text-center" style="vertical-align: middle;">Pilih</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if($proses == 'nonaktif'){
                        $no = 1;
                        foreach ($listData as $item){
                ?>
                    <tr>
                        <td><?= $no++ ?>.</td>
                        <td style="width: 13%"><?= isset($item['kode_anggota']) ? Html::encode($item['kode_anggota']) : '' ?></td>
                        <td><?= isset($item['nama_peserta']) ? Html::encode($item['nama_peserta']) : '' ?></td>
                        <td><?= isset($item['unit_bisnis']) ? Html::encode($item['unit_bisnis']) : '' ?></td>
                        <td><?= isset($item['nama']) ? Html::encode($item['nama']) : '' ?></td>
                        <td><?= isset($item['nama_cabang']) ? Html::encode($item['nama_cabang']) : '' ?></td>
                        <td style="width: 10%" class="text-center"><?= isset($item['tgl_keluar']) ? Html::encode(date("d-m-Y", strtotime($item['tgl_keluar']))) : '' ?></td>
                        <td class="text-center" style="vertical-align: middle;"><?= Html::checkbox('selectedItems[]', false, ['value' => $item['kode_anggota']]) ?></td>
                    </tr>
                <?php
                        } 
                    }else{
                        for ($i = 0; $i < 5; $i++){
                ?>
                        <tr>
                            <td></td>
                            <td style="width: 13%"></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td style="width: 10%" class="text-center"></td>
                            <td class="text-center" style="vertical-align: middle;"></td>
                        </tr>
                <?php
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>

    <p>
        <?= Html::button('Update Status Peserta', [
            'class' => 'btn btn-warning',
            'style' => 'width: 180px; color: black; font-weight: bold;',
            'id' => 'update-button',
            'disabled' => $proses !== 'nonaktif',
        ]) ?>
    </p>
    <p>
        <?= Html::a('Keluar', ['indexnonaktifpeserta'], ['class' => 'btn btn-default', 'style' => 'width: 180px; color: black; font-weight: bold;']) ?>
    </p>

</div>
<?php
    $url = Yii::$app->urlManager->createUrl(['mspeserta/syncnonaktifpeserta']);
    $script = <<< JS
        $('#update-button').on('click', function() {
            var updateButton = $(this);
            updateButton.prop('disabled', true);
            updateButton.html('Loading...');
            
            var checkedItems = $('input[name="selectedItems[]"]:checked');
            
            if (checkedItems.length === 0) {
                updateButton.html('Update Status Peserta'); // Mengembalikan teks tombol ke semula
                updateButton.prop('disabled', false);
                alert('Belum ada yang diceklis.');
            } else {
                var confirmed = confirm('Apakah Anda yakin akan menonaktifkan peserta data terpilih?');
                if (confirmed) {
                    var selectedKodeanggota = checkedItems.map(function() {
                        return $(this).val();
                    }).get();
                    
                    // Send AJAX request
                    $.ajax({
                        url: '$url',
                        method: 'POST',
                        data: {
                            selectedItems: selectedKodeanggota
                        },
                        success: function(response) {
                            // Handle success response
                        },
                        error: function() {
                            updateButton.html('Update Status Peserta'); // Mengembalikan teks tombol ke semula
                            updateButton.prop('disabled', false);
                            // Handle error
                        }
                    });
                }else{
                    updateButton.html('Update Status Peserta'); // Mengembalikan teks tombol ke semula
                    updateButton.prop('disabled', false);
                }
            }
        });
    JS;

    $this->registerJs($script);
?>
