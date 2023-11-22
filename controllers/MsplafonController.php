<?php

namespace app\controllers;

use Yii;
use app\models\MsPlafon;
use app\models\MsplafonSearch;
use app\models\MsJenisPlafon;
use app\models\MsLevel;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * MsplafonController implements the CRUD actions for MsPlafon model.
 */
class MsplafonController extends Controller
{
    public function init()
	{
		parent::init();
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
     * Lists all MsPlafon models.
     * @return mixed
     */
    public function actionIndex()
    {
		$searchModel = new MsplafonSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->get());

		return $this->render('index', [
			'dataProvider' => $dataProvider,
			'searchModel' => $searchModel,
		]);
    }

    /**
     * Displays a single MsPlafon model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
		$model = $this->findModel($id);
        return $this->render('view', [
            'model' => $model
        ]);
    }

    /**
     * Creates a new MsPlafon model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MsPlafon();

        if ($model->load(Yii::$app->request->post())) {
			$model->input_by = Yii::$app->user->identity->username;
			$model->input_date = date("Y-m-d H:i:s");
			if($model->save()){
				return $this->redirect(['view', 'id' => $model->id]);
			}
        }

		$dataPlafon = MsJenisPlafon::find()->all();
		$listPlafon = ArrayHelper::map($dataPlafon,'nama_plafon','nama_plafon');
		$modelLevel = new MsLevel();
		$dataLevel = $modelLevel->find()->all();
		$listJabatan = ArrayHelper::map($dataLevel,'level_jabatan','level_jabatan');

        return $this->render('create', [
            'model' => $model,
			'listPlafon' => $listPlafon,
			'listJabatan' => $listJabatan,
        ]);
    }

    /**
     * Updates an existing MsPlafon model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
			$model->modi_by = Yii::$app->user->identity->username;
			$model->modi_date = date("Y-m-d H:i:s");
			if($model->save()){
				return $this->redirect(['view', 'id' => $model->id]);
			}
        }

        return $this->render('update', [
            'model' => $model
        ]);
    }

    /**
     * Deletes an existing MsPlafon model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the MsPlafon model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MsPlafon the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MsPlafon::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
