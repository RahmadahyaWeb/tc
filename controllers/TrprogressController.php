<?php

namespace app\controllers;

use Yii;
use app\models\TrProgress;
use app\models\MsProgress;
use app\models\MsPeserta;
use app\models\TrProgressSearch;
use Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * TrprogressController implements the CRUD actions for TrProgress model.
 */
class TrprogressController extends Controller
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
     * Lists all TrProgress models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TrProgressSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TrProgress model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCekresi()
    {   
        $modelPeserta = new MsPeserta();
        if(isset($_GET['TrProgressSearch']['resi'])){
            $model = new TrProgressSearch();
            $id = $_GET['TrProgressSearch']['resi'];
            return $this->render('cekresi', [
                'model' => $this->findModel($id),
            ]);
        } else {
            $searchModel = new TrProgressSearch();
            $strsearch = null;
            if(Yii::$app->user->identity->user_group != 'admin') {
                $kode_anggota = Yii::$app->user->identity->username;
                $datapeserta = $modelPeserta->getPesertaAll($kode_anggota);
                $strsearch = "";
                foreach($datapeserta as $da){
                    $strsearch .= "'".$da->id."',";
                }
                $strsearch = substr($strsearch,0,-1);
            }
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$strsearch);
            return $this->render('searchresi', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
    }

    /**
     * Creates a new TrProgress model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TrProgress();

        if ($model->load(Yii::$app->request->post())) {
            $model->status = "OnProgress";
            //$model->status_date = date("Y-m-d");
            $model->progress = 1;
            // $model->progress_1 = date("Y-m-d");
            $model->input_by = Yii::$app->user->identity->username;
            $model->input_date = date("Y-m-d");
            $model->resi = date("Ymdhis").str_pad($model->id_peserta,7,"0",STR_PAD_LEFT);
            try{
                if($model->save()){
                    return $this->redirect(['view', 'id' => $model->resi]);
                }
            } catch (Exception $e){
                Yii::$app->session->setFlash('error', $e->errorInfo[2]);
            }
        }

        $mspeserta = new MsPeserta();
        
        return $this->render('create', [
            'model' => $model,
            'listPeserta' => $mspeserta->listPeserta(),
        ]);
    }

    /**
     * Updates an existing TrProgress model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelold = $this->findModel($id);
		if ($model->load(Yii::$app->request->post())) {
			$model->modif_by = Yii::$app->user->identity->username;
            $model->modif_date = date("Y-m-d");
            if((int)$model->progress < (int)$modelold->progress){
				$model->progress = $modelold->progress;
			}
            if($model->status <> 'OnProgress'){
                $model->status_date = date("Y-m-d");
            }
            try{
                if($model->save()){
                    return $this->redirect(['view', 'id' => $model->resi]);
                }
            } catch (Exception $e){
                Yii::$app->session->setFlash('error', $e->errorInfo[2]);
            }
            
        }

        $msprogress = new MsProgress();

        return $this->render('update', [
            'model' => $model,
            'listProgress' => $msprogress->listProgress(),
            'listStatus' => $msprogress->listStatus(),
        ]);
    }

    /**
     * Deletes an existing TrProgress model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TrProgress model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return TrProgress the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TrProgress::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
