<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MsProviderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Benefit Tricare';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ms-provider-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>Daftar Benefit yang didapatkan oleh peserta Tricare</p>
    <?php 
    if(count($dataProvider) > 0 ){
        foreach($dataProvider as $da){
            $link = Yii::$app->request->baseUrl.'/../'.$da['link'];
            echo '<ul>';
            echo '<li><a target = "popup-example" href="'.$link.'" onclick = "javascript:open(\'#\', \'popup-example\', \'height=\'+window.innerheight+\',width=\'+window.innerwidth+\'resizable=no\')">'.$da['judul'].'</a></li>';
            echo '</ul>';
        }
    } else {
        echo '~ Belum Ada Data. ~';
    }
    
    
    ?>
</div>
