<?php

namespace app\controllers;

use Yii;
use app\models\MsProvider;
use app\models\User_manage;
use app\models\User;
use app\models\MsProviderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * MsproviderController implements the CRUD actions for MsProvider model.
 */
class MsproviderController extends Controller
{
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            // Periksa apakah pengguna sudah login
            if (Yii::$app->user->isGuest) {
                // Jika pengguna belum login, arahkan mereka ke halaman login
                Yii::$app->user->loginRequired();
                return false;
            }

            return true;
        } else {
            return false;
        }
    }

    public function checkuser()
    {
      if(Yii::$app->user->identity->user_group != 'admin') {
       return $this->goHome();
   }
	}/**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all MsProvider models.
     * @return mixed
     */
    public function actionIndex()
    {
      $this->checkuser();
      $searchModel = new MsProviderSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      $model = new MsProvider();

      $listJenisProvider= ArrayHelper::map($model->listJenisProvider(),'code','code');

      return $this->render('index', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'listJenisProvider' => $listJenisProvider,
    ]);
  }

  public function actionIndexpeserta()
  {
    $searchModel = new MsProviderSearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    $model = new MsProvider();

    $listJenisProvider= ArrayHelper::map($model->listJenisProvider(),'code','code');

    return $this->render('indexpeserta', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'listJenisProvider' => $listJenisProvider,
    ]);
}

    /**
     * Displays a single MsProvider model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
      $this->checkuser();
      return $this->render('view', [
        'model' => $this->findModel($id),
    ]);
  }

    /**
     * Creates a new MsProvider model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->checkuser();
        $model = new MsProvider();
        if ($model->load(Yii::$app->request->post())) {
         $model->input_by = Yii::$app->user->identity->username;
         $model->input_date = date("Y-m-d H:i:s");
         if($model->save()){
            // save user
            $user = new User_manage();
            $userModel = new User();
            $user->username = Yii::$app->request->post('username');
            $user->password = $userModel->encong(Yii::$app->request->post('username'), Yii::$app->request->post('password'));
            $user->id_provider = $model->id;
            $user->user_group = 'provider';
            $user->active = 1;
            $user->save();

            return $this->redirect(['view', 'id' => $model->id]);
        }
    }
    $listJenisProvider= ArrayHelper::map($model->listJenisProvider(),'code','code');

    return $this->render('create', [
        'model' => $model,
        'listJenisProvider' => $listJenisProvider,
    ]);
}

    /**
     * Updates an existing MsProvider model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $this->checkuser();
        $model = $this->findModel($id);

        // CEK APAKAH PROVIDER SUDAH MEMILIKI AKUN ATAU BELUM
        $cek_akun = (new yii\db\Query())
        ->select(["*"])
        ->from("user")
        ->where(["user.id_provider" => $model["id"]])
        ->count();

        if ($model->load(Yii::$app->request->post())) {
           $model->modi_by = Yii::$app->user->identity->username;
           $model->modi_date = date("Y-m-d H:i:s");
           if($model->save()){
               $user = new User_manage();
               $userModel = new User();
               $user->username = Yii::$app->request->post('username');
               $user->password = $userModel->encong(Yii::$app->request->post('username'), Yii::$app->request->post('password'));
               $user->id_provider = $model->id;
               $user->user_group = 'provider';
               $user->save();

               return $this->redirect(['view', 'id' => $model->id]);
           }
       }
       
       $listJenisProvider= ArrayHelper::map($model->listJenisProvider(),'code','code');

       return $this->render('update', [
        'model' => $model,
        'listJenisProvider' => $listJenisProvider,
        'cek_akun' => $cek_akun
    ]);
   }

    /**
     * Deletes an existing MsProvider model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
      $this->checkuser();
      $user = new User_manage();
      $user::updateAll([
          "active" => '-1'
      ], [
          "id_provider" => $id
      ]);

      $this->findModel($id)->delete();

      return $this->redirect(['index']);
  }

    /**
     * Finds the MsProvider model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MsProvider the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MsProvider::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
