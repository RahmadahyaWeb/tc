<?php

namespace app\controllers;

use Yii;
use app\models\MsPlafonextend;
use app\models\MsPlafonextendSearch;
use app\models\MsJenisPlafon;
use app\models\MsLevel;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * MsplafonextendController implements the CRUD actions for MsPlafonextend model.
 */
class MsplafonextendController extends Controller
{
    /**
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
     * Lists all MsPlafonextend models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MsPlafonextendSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MsPlafonextend model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new MsPlafonextend model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MsPlafonextend();

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
		ArrayHelper::setValue($listJabatan, 'TANGGUNGAN', 'TANGGUNGAN');
		
		$listAnggota = [
			1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5
		];
		
        return $this->render('create', [
            'model' => $model,
			'listPlafon' => $listPlafon,
			'listJabatan' => $listJabatan,
			'listAnggota' => $listAnggota
        ]);
    }

    /**
     * Updates an existing MsPlafonextend model.
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
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing MsPlafonextend model.
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
     * Finds the MsPlafonextend model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MsPlafonextend the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MsPlafonextend::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
