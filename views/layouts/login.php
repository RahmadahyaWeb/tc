<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\ProviderAsset;
use app\widgets\Alert;
use Yii\helpers\Html;

ProviderAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
  <title><?= Html::encode($this->title) ?></title>
  <?php $this->head() ?>
  <style type="text/css">
    /*LOGIN PAGE*/
    .login{
      background-color: rgba(0,0,0, 0.5);
      color: white;
      text-transform: uppercase;
      font-weight: bold;
      padding: 10px;
    }

    .bg-img{
      background: url("../dummy.webp");
      background-size: cover  ;

    </style>
  </head>
  <body class="bg-img">
    <?php $this->beginBody() ?>

<!-- <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav ms-auto">
        <a class="nav-link" href="<?= \yii\helpers\Url::to(['/login/login']) ?>">
            <i class="fa-solid fa-right-to-bracket"></i>
            LOGIN
        </a>
      </div>
    </div>
  </div>
</nav> -->

<div class="container">
  <?= $content;  ?>
</div>




<?php $this->endBody() ?>

</body>
</html>

<?php $this->endPage() ?>

