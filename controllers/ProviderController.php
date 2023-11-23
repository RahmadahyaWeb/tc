<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginProvider;
use app\models\ContactForm;
use yii\helpers\Url;
use app\models\User;
use app\models\MsProvider;

class ProviderController extends Controller
{
    public $layout = 'provider';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],

            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['get'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(array('/provider/login'));
        } elseif(Yii::$app->user->identity->id_provider == null){
            
            return $this->redirect(array('/provider/logout'));
        }

        return $this->render('index');
    }

    public function actionLogin()
    {
        // Mendifinisikan layout login
        $this->layout = 'login';

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginProvider();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        return $this->render('login', [
            'errors' => $model->errors,
            'values' => Yii::$app->request->post('LoginProvider')
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionProfile()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(array('/provider/login'));
        } elseif(Yii::$app->user->identity->id_provider == null) {
            return $this->redirect(array('/provider/logout'));
        }

        $provider = MsProvider::find()
        ->joinWith('user')
        ->where("user.id_provider = '" . Yii::$app->user->identity->id_provider . "'")
        ->one();

        return $this->render('profile', [
            'provider' => $provider
        ]);
    }

    public function actionDownload()
    {   
        if (Yii::$app->user->isGuest) {
            return $this->redirect(array('/provider/login'));
        } elseif(Yii::$app->user->identity->id_provider == null) {
            return $this->redirect(array('/provider/logout'));
        }

        $documents = (new yii\db\Query())
        ->select(["ms_benefit.judul", "ms_benefit.link", "ms_benefit.level_akses"])
        ->from("ms_benefit")
        ->where(["ms_benefit.level_akses" => "Provider"])
        ->all();

        return $this->render('download', [
            "documents" => $documents
        ]);
    }
}
