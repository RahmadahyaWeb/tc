<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
	<meta charset="<?= Yii::$app->charset ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php $this->registerCsrfMetaTags() ?>
	<title><?= Html::encode($this->title) ?></title>
	<?php $this->head() ?>
	<link rel="shortcut icon" type="image/png" href="images/icon.ico" />
	<!-- </head> -->
</head>
<style>
	<?php
	if ($this->title == "My Tricare") {
		echo 'body {
			background-image: url(\'images/1-bg.jpg\');
			background-position: center;
			background-attachment: fixed;
			background-size: cover;
		}';
	} else {
		echo 'body {
			background-image: url(\'images/4-bg.jpg\');
			background-position: center;
			background-attachment: fixed;
			background-size: cover;
		}';
	}
	?>
</style>

<body>
	<?php $this->beginBody() ?>
	<div class="wrap">
		<?php
		NavBar::begin([
			'brandLabel' => "My TRICARE",
			'brandUrl' => Yii::$app->homeUrl,
			'options' => [
				'class' => 'navbar-inverse navbar-fixed-top',
			],
		]);
		if (Yii::$app->user->isGuest) {
			echo Nav::widget([
				'options' => ['class' => 'navbar-nav navbar-right'],
				'items' => [
					['label' => 'Login', 'url' => ['/site/login']]
				],
			]);
		} else if (Yii::$app->user->identity->user_group == 'admin') {
			echo Nav::widget([
				'options' => ['class' => 'navbar-nav navbar-right'],
				'items' => [
					['label' => 'Home', 'url' => ['/site/index']],
					[
						'label' => 'Admin',
						'items' => [
							['label' => 'Progress Tricare', 'url' => ['/trprogress']],
							'<li class="divider"></li>',
							['label' => 'Progress Tricare Provider', 'url' => ['/tr-progress-provider']],
							'<li class="divider"></li>',
							['label' => 'Rekap Pemakaian Tricare', 'url' => ['/trplafon/rekap']],
							'<li class="divider"></li>',
							['label' => 'Trans Pemakaian Tricare', 'url' => ['/trplafon']],
							'<li class="divider"></li>',
							['label' => 'Iuran Bulanan', 'url' => ['/trplafon/iuranbulanan']],
							'<li class="divider"></li>',
							['label' => 'Pembuatan Surat', 'url' => ['/trsurat']],
							'<li class="divider"></li>',
							['label' => 'Non Aktif Peserta', 'url' => ['/mspeserta/indexnonaktifpeserta']]
						],
					],
					[
						'label' => 'Master',
						'items' => [
							['label' => 'Master Config', 'url' => ['/msconfig']],
							'<li class="divider" style="margin:3px"></li>',
							['label' => 'Master Benefit', 'url' => ['/msbenefit']],
							'<li class="divider" style="margin:3px"></li>',
							['label' => 'Master Departemen', 'url' => ['/msdepartemen']],
							'<li class="divider" style="margin:3px"></li>',
							['label' => 'Master Jenis Plafon', 'url' => ['/msjenisplafon']],
							'<li class="divider" style="margin:3px"></li>',
							['label' => 'Master Level/Jabatan', 'url' => ['/mslevel']],
							'<li class="divider" style="margin:3px"></li>',
							['label' => 'Master Peserta', 'url' => ['/mspeserta']],
							'<li class="divider" style="margin:3px"></li>',
							['label' => 'Master Plafon', 'url' => ['/msplafon']],
							'<li class="divider" style="margin:3px"></li>',
							['label' => 'Master Plafon 2', 'url' => ['/msplafonextend']],
							'<li class="divider" style="margin:3px"></li>',
							['label' => 'Master Provider', 'url' => ['/msprovider']],
							'<li class="divider" style="margin:3px"></li>',
							['label' => 'Master Tujuan Surat', 'url' => ['/mstujuansurat']],
							'<li class="divider" style="margin:3px"></li>',
							['label' => 'Master UP Surat', 'url' => ['/msupsurat']],
							'<li class="divider" style="margin:3px"></li>',
							['label' => 'Master Unit Bisnis', 'url' => ['/msunitbisnis']],
							'<li class="divider" style="margin:3px"></li>',
							['label' => 'Master User', 'url' => ['/usermanage']],
						],
					],
					[
						'label' => 'Peserta',
						'items' => [
							['label' => 'Lacak Klaim Tricare', 'url' => ['/trprogress/cekresi']],
							'<li class="divider"></li>',
							['label' => 'Pemakaian dan Sisa Plafon', 'url' => ['/trplafon/indexpeserta']],
							'<li class="divider"></li>',
							['label' => 'Daftar Provider', 'url' => ['/msprovider/indexpeserta']],
							'<li class="divider"></li>',
							['label' => 'Benefit Tricare', 'url' => ['/msbenefit/indexpeserta']],
							'<li class="divider"></li>',
							['label' => 'Ganti Password', 'url' => ['/usermanage/gantipass']],
						],
					],
					'<li>'
						. Html::beginForm(['/site/logout'], 'post')
						. Html::submitButton(
							'Logout (' . Yii::$app->user->identity->username . ')',
							['class' => 'btn btn-link logout']
						)
						. Html::endForm()
						. '</li>'

				],
			]);
		} else {
			echo Nav::widget([
				'options' => ['class' => 'navbar-nav navbar-right'],
				'items' => [
					[
						'label' => 'Peserta',
						'items' => [
							['label' => 'Lacak Klaim Tricare', 'url' => ['/trprogress/cekresi']],
							'<li class="divider"></li>',
							['label' => 'Pemakaian dan Sisa Plafon', 'url' => ['/trplafon/indexpeserta']],
							'<li class="divider"></li>',
							['label' => 'Daftar Provider', 'url' => ['/msprovider/indexpeserta']],
							'<li class="divider"></li>',
							['label' => 'Benefit Tricare', 'url' => ['/msbenefit/indexpeserta']],
							'<li class="divider"></li>',
							['label' => 'Ganti Password', 'url' => ['/usermanage/gantipass']],
							'<li class="divider"></li>',
							['label' => 'Download Kartu', 'url' => ['/mspeserta/printkartu', 'kode_anggota' => Yii::$app->user->identity->username]],
						],
					],
					'<li>'
						. Html::beginForm(['/site/logout'], 'post')
						. Html::submitButton(
							'Logout (' . Yii::$app->user->identity->username . ')',
							['class' => 'btn btn-link logout']
						)
						. Html::endForm()
						. '</li>'

				],
			]);
		}

		NavBar::end();
		?>

		<div class="container">
			<?= Breadcrumbs::widget([
				'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
			]) ?>
			<?= Alert::widget() ?>
			<?= $content ?>
		</div>
	</div>

	<footer class="footer">
		<div class="container">
			<p class="pull-left">&copy; PT Trio Motor 2020 <?php //= date('Y') 
															?></p>

			<!--p class="pull-right"><? //= Yii::powered() 
										?></p-->
		</div>
	</footer>

	<?php $this->endBody() ?>
	<!-- </body></html> -->
</body>

</html>
<?php $this->endPage() ?>