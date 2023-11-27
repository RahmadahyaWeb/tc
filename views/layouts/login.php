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
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/images/icon.ico')]);
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
      }
    </style>
  </head>
  <body class="bg-img">
    <?php $this->beginBody() ?>

<div class="container">
  <?= $content;  ?>
</div>




<?php $this->endBody() ?>

</body>
</html>

<?php $this->endPage() ?>

