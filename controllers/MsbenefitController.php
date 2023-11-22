<?php

namespace app\controllers;

use Yii;
use app\models\MsBenefit;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\Web\UploadedFile;

/**
 * MsbenefitController implements the CRUD actions for MsBenefit model.
 */
class MsbenefitController extends Controller
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

    public function checkuser()
	{
		if(Yii::$app->user->identity->user_group != 'admin') {
			return $this->goHome();
		}
	}

    /**
     * Lists all MsBenefit models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->checkuser();
        $dataProvider = new ActiveDataProvider([
            'query' => MsBenefit::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MsBenefit model.
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
     * Creates a new MsBenefit model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->checkuser();
        $model = new MsBenefit();

        if ($model->load(Yii::$app->request->post())) {
            $model->create_by = Yii::$app->user->identity->username;
            $model->create_time = date("Y-m-d H:i:s");
            $link_file = UploadedFile::getInstance($model,'link');
			$model->link_file = $link_file;
			$nama_memo = $model->link_file->baseName.'.'.$model->link_file->extension;
			$new_nama_memo = $model->judul.date("YmdHis").'.'.$model->link_file->extension;
			$model->link = 'files/benefit/'.$new_nama_memo;
            if($model->save()){
                $model->link_file->saveAs(\Yii::$app->basePath.'/files/benefit/'.$nama_memo);
				rename(\Yii::$app->basePath.'/files/benefit/'.$nama_memo, \Yii::$app->basePath.'/files/benefit/'.$new_nama_memo);
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing MsBenefit model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $this->checkuser();
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->modif_by = Yii::$app->user->identity->username;
            $model->modif_time = date("Y-m-d H:i:s");
            $link_file = UploadedFile::getInstance($model,'link');
			$model->link_file = $link_file;
			$nama_memo = $model->link_file->baseName.'.'.$model->link_file->extension;
			$new_nama_memo = $model->judul.date("YmdHis").'.'.$model->link_file->extension;
			$model->link = 'files/benefit/'.$new_nama_memo;
			if($model->save()){
                $model->link_file->saveAs(\Yii::$app->basePath.'/files/benefit/'.$nama_memo);
				rename(\Yii::$app->basePath.'/files/benefit/'.$nama_memo, \Yii::$app->basePath.'/files/benefit/'.$new_nama_memo);
                return $this->redirect(['view', 'id' => $model->id]);
            }
            
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing MsBenefit model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->checkuser();
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the MsBenefit model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MsBenefit the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MsBenefit::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionIndexpeserta(){

        $model = new MsBenefit();
        
        if (Yii::$app->user->identity->user_group == "admin") {
            $data = $model->find()->all();
        } else {
            $data = $model->find()->where(["level_akses" => "Peserta"])->all();
        }

		return $this->render('indexpeserta', [
            'dataProvider' => $data,
        ]);
    }
}
