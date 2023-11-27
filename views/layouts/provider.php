<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\ProviderAsset;
use app\widgets\Alert;
use yii\helpers\Html;

ProviderAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/images/icon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <style>
        .item {
          display: list-item;
          table-layout: fixed;
          list-style-type: none;
          list-style-position: outside;
          padding: 40px 50px;
          line-height: 1.14285714em;
          position: relative;
      }

      .item:after {
          position: absolute;
          top: 0;
          left: 21px;
          width: 0px;
          height: 100%;
          content: '';
          border-right: 4px solid white;
      }

      .item:first-child:after {
          top: 50%;
          height: 50%;
      }

      .item:last-child:after {
          position: absolute;
          bottom: 50%;
          height: 50%;
      }

      .title {
          font-weight: 700;
      }

      .bg-img{
        background-image: url('<?= Yii::$app->request->baseUrl.'/dummy.webp' ?>');
        background-size: cover;
    }
    .info {
        overflow: hidden; /* Mengatasi float */
    }

    .label {
        float: left;
        width: 300px; /* Sesuaikan lebar sesuai kebutuhan Anda */
        text-align: left;
        padding-right: 10px; /* Beri jarak dari tanda ":" */
        font-size: 30px;
    }

    .value {
        float: left;
        font-size: 30px;
    }

    .info:after {
        content: "";
        display: table;
        clear: both;
    }

    .teks-pojok-kanan-bawah {
      position: absolute;
      bottom: 0;
      right: 0;
      margin-right: 7rem;
      margin-bottom: 7rem;
      font-size: 80px;
      font-weight: bold;
  }

</style>
</head>

<body class="sb-nav-fixed bg-img">
    <?php $this->beginBody() ?>

    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3 fw-bold transparan" href="<?= \yii\helpers\Url::to(['/provider/index']) ?>">
            <!-- <img src="../tricare-provider/images/logo.png" alt="Logo" class="d-inline-block img-fluid" style="width: 65%"> -->
            <img src="<?= Yii::$app->request->baseUrl.'/images/logo.png' ?>" alt="Logo" class="d-inline-block img-fluid" style="width: 65%">
        </a>
        <!-- Sidebar Toggle-->
        <!-- <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button> -->
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <?= (!Yii::$app->user->isGuest) ? Yii::$app->user->identity->provider->nama : '' ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li>
                        <a class="dropdown-item" href="<?= \yii\helpers\Url::to(['/provider/profile']) ?>">
                            PROFILE USER
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li>
                        <a class="dropdown-item" href="<?= \yii\helpers\Url::to(['/provider/logout']) ?>">LOG OUT</a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion" id="sidenavAccordion">
                <div class="sb-sidenav-menu transparan">
                    <div class="nav">
                        <a class="nav-link <?= ($this->title == 'HOME') ? 'active' : '' ?>" href="<?= \yii\helpers\Url::to(['/provider/index']) ?>">
                            HOME
                        </a>
                        <a class="nav-link <?= ($this->title == 'DATA KEPESERTAAN') ? 'active' : '' ?>" href="<?= \yii\helpers\Url::to(['/peserta-provider/index']) ?>">
                            DATA KEPESERTAAN
                        </a>
                        <a class="nav-link <?= ($this->title == 'DATA HAK KELAS & PLAFON KEPESERTAAN') ? 'active' : '' ?>" href="<?= \yii\helpers\Url::to(['/kelas-plafon/index']) ?>">
                            DATA HAK KELAS & PLAFON KEPESERTAAN
                        </a>
                        <a class="nav-link <?= ($this->title == 'PROGRESS PEMBAYARAN TAGIHAN') ? 'active' : '' ?>" href="<?= \yii\helpers\Url::to(['/progress-provider/index']) ?>">
                            PROGRESS PEMBAYARAN TAGIHAN
                        </a>
                        <a class="nav-link <?= ($this->title == 'DOWNLOAD') ? 'active' : '' ?>" href="<?= \yii\helpers\Url::to(['/provider/download']) ?>">
                            DOWNLOAD
                        </a>
                    </div>
                </div>
<!--                 <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    Start Bootstrap
                </div> -->
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4 my-3 text-white">
                    <?= Alert::widget() ?>
                    <?= $content ?>
                </div>
            </main>
            <footer class="py-3 mt-auto" style="background-color: lightgrey;">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-dark" style="font-size: 20px; font-weight: 500;">&copy; PT TRIO MOTOR 2023</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <?php $this->endBody() ?>
</body>

</html> 
<?php $this->endPage() ?>