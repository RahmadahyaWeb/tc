<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\number\NumberControl;
use yii\helpers\Url;

$this->title = 'Rekap Data Over Plafon ';
$this->params['breadcrumbs'][] = $this->title;

// PAGINATION
$perPage = 10;
$totalData = $dataProvider->getTotalCount();
$currentPage = Yii::$app->request->get('page', 1);
$offset = ($currentPage - 1) * $perPage;
$models = $dataProvider->query->offset($offset)->limit($perPage)->all();
?>

<div class="tr-plafon-over">

    <h1><?= Html::encode($this->title) ?></h1>

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Kode Anggota</th>
                <th>Nama Peserta</th>
                <th>Nama Plafon</th>
                <th>Periode Tahun</th>
                <th>Biaya Over</th>
                <th>Status</th>
                <th></th>
            </tr>
            <tr>
                <form action="<?= \yii\helpers\Url::to(['/trplafon-over/index']) ?>" method="post">
                    <input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken() ?>" />
                    <th></th>
                    <th>
                        <input type="text" name="kode_anggota" class="form-control" onchange="this.form.submit()" value="<?= isset($data['kode_anggota']) ? $data['kode_anggota'] : '' ?>" />
                    </th>
                    <th>
                        <input type="text" name="nama_peserta" class="form-control" onchange="this.form.submit()" value="<?= isset($data['nama_peserta']) ? $data['nama_peserta'] : '' ?>" />
                    </th>
                    <th>
                        <select name="nama_plafon" class="form-control" onchange="this.form.submit()">
                            <option value="">-- LIST ALL --</option>
                            <?php foreach ($listPlafon as $plafon) : ?>
                                <option value="<?= $plafon ?>" <?= ($searchModel->nama_plafon == $plafon) ? 'selected' : '' ?>>
                                    <?= $plafon ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </th>
                    <th></th>
                    <th></th>
                    <th></th>
                </form>
            </tr>
        </thead>
        <tbody>
            <?php if (count($dataProvider->getModels()) > 0) :  ?>
                <?php foreach ($dataProvider->getModels() as $index => $model) : ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= $model->peserta->kode_anggota ?></td>
                        <td><?= $model->peserta->nama_peserta ?></td>
                        <td><?= $model->nama_plafon ?></td>
                        <td style="width: 150px"><?= $model->tanggal ?></td>
                        <td><?= NumberControl::widget([
                                'name' => 'biaya',
                                'value' => $model->biaya,
                                'disabled' => true,
                                'maskedInputOptions' => ['prefix' => 'Rp. '],
                                'displayOptions' => ['style' => 'width:180px'],
                            ]); ?>
                        </td>
                        <td style="width: 120px;text-transform: uppercase">
                            <?php if ($model->status == '' || $model->status == null) :  ?>
                                Belum Lunas
                            <?php else : ?>
                                <?= $model->status ?>
                            <?php endif; ?>
                        </td>
                        <td style="width: 100px; text-align: center">
                            <a href="<?= Url::to(['/trplafon-over/update', 'id' => $model->id]) ?>">View Detail</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="8">No Results found.</td>
                </tr>
            <?php endif; ?>

        </tbody>
    </table>

    <p>Catatan : <i>Harap segera lapor ke Pengurus Tricare untuk mekanisme pengembalian biaya over plafon</i></p>

    <?php
    echo \yii\widgets\LinkPager::widget([
        'pagination' => new \yii\data\Pagination([
            'totalCount' => $totalData,
            'pageSize' => $perPage,
            'defaultPageSize' => $perPage,
        ]),
    ]);
    ?>

</div>