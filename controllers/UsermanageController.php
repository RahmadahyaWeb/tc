<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\User_manage;
use app\models\User_manageSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UsermanageController implements the CRUD actions for User_manage model.
 */
class UsermanageController extends Controller
{
	public function checkuser()
	{
		if(Yii::$app->user->identity->user_group != 'admin') {
			return $this->goHome();
		}
	}
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
     * Lists all User_manage models.
     * @return mixed
     */
    public function actionIndex()
    {
		$this->checkuser();
        $searchModel = new User_manageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		//var_dump($dataProvider);exit();
		return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User_manage model.
     * @param string $id
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
     * Creates a new User_manage model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
		$this->checkuser();
        $model = new User_manage();
		
		if ($model->load(Yii::$app->request->post())) {
			$usermodel = new User();
			$model->password = $usermodel->encong($model->username, $model->password);
			if ($model->save()){
				return $this->redirect(['view', 'id' => $model->id]);
			}
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User_manage model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
		$this->checkuser();
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
	
	public function actionGantipass()
    {
		$id = Yii::$app->user->identity->username;
		$query = new User_manage();
		$model = $query->find()->where("username = '".$id."'")->one();
		//var_dump($data->username);exit();
        if ($model->load(Yii::$app->request->post())) {
			if($model->newpw != $model->newpw2){
				$model->addError('newpw2', 'Password konfirmasi tidak sama!');
			} else {
				$model->modi_by = Yii::$app->user->identity->username;
				$model->modi_date = date("Y-m-d H:i:s");
				$model->active = 1;
				$usermodel = new User();
				$model->password = $usermodel->encong($id, $model->newpw);
				if($model->save()){
					return $this->goHome();
				}
			}
			
        }
		
		return $this->render('changepassword', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing User_manage model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
		$this->checkuser();
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
	
	public function actionReset($id)
    {
		$this->checkuser();
		$model = $this->findModel($id);
		$usermodel = new User();
		$password = $usermodel->encong($model->username, 'password');
		$active = 0;
		$modi_by = Yii::$app->user->identity->username;
		$modi_date = date("Y-m-d H:i:s");
		if(User::updateAll(['password'=> $password, 'active'=>0, 'modi_by' => $modi_by, 'modi_date' => $modi_date], "id = '".$id."'")){
			return $this->redirect(['view', 'id' => $id]);
		}
		return $this->redirect(['index']);
    }

    /**
     * Finds the User_manage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return User_manage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User_manage::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
