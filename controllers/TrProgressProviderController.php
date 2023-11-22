<?php

namespace app\controllers;

use Yii;
use app\models\TrProgressProvider;
use app\models\TrProgressProviderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\Web\UploadedFile;


/**
 * TrProgressProviderController implements the CRUD actions for TrProgressProvider model.
 */
class TrProgressProviderController extends Controller
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
     * Lists all TrProgressProvider models.
     * @return mixed
     */
    public function actionIndex()
    {

        if (Yii::$app->user->isGuest) {
            return $this->redirect(array('/site/login'));
        } elseif (Yii::$app->user->identity->id_provider !== null) {
            return $this->redirect(array('/site/logout'));
        }

        $searchModel = new TrProgressProviderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TrProgressProvider model.
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

    /**
     * Creates a new TrProgressProvider model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(array('/site/login'));
        } elseif (Yii::$app->user->identity->id_provider !== null) {
            return $this->redirect(array('/site/logout'));
        }

        $model = new TrProgressProvider();

        if ($model->load(Yii::$app->request->post())) {
            // Generate resi otomatis
            $model->resi = date("YmdHis") . rand(111, 999);

            $bukti_pembayaran = UploadedFile::getInstance($model, 'bukti_pembayaran');

            if ($model->validate()) {
                $model->save();
                if (!empty($bukti_pembayaran)) {
                    $bukti_pembayaran->saveAs(\Yii::$app->basePath . '/files/bukti-pembayaran/' . $model->resi . '.' . $bukti_pembayaran->extension);
                    $model->bukti_pembayaran = 'files/bukti-pembayaran/' . $model->resi . '.' . $bukti_pembayaran->extension;
                    $model->save(FALSE);
                }
            }

            $model->save();
            return $this->redirect(['view', 'id' => $model->resi]);
        }

        // Ambil data provider
        $data_provider = (new \yii\db\Query())
        ->select(["*"])
        ->from("ms_provider")
        ->all();
        $list_provider = ArrayHelper::map($data_provider, 'id', 'nama');

        return $this->render('create', [
            'model' => $model,
            'list_provider' => $list_provider,
            'errors' => $model->errors
        ]);
    }

    /**
     * Updates an existing TrProgressProvider model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(array('/site/login'));
        } elseif (Yii::$app->user->identity->id_provider !== null) {
            return $this->redirect(array('/site/logout'));
        }

        $model = $this->findModel($id);

        // Simpan file bukti pembayaran yang sebelumnya disimpan
        $existingBuktiPembayaran = $model->bukti_pembayaran;


        if ($model->load(Yii::$app->request->post())) {

            $bukti_pembayaran = UploadedFile::getInstance($model, 'bukti_pembayaran');

            if ($model->validate()) {
                // Hanya simpan jika file bukti_pembayaran baru diunggah
                if (!empty($bukti_pembayaran)) {
                    // Simpan file bukti pembayaran baru
                    $filePath = \Yii::$app->basePath . '/files/bukti-pembayaran/' . $model->resi . '.' . $bukti_pembayaran->extension;
                    $bukti_pembayaran->saveAs($filePath);
                    $model->bukti_pembayaran = 'files/bukti-pembayaran/' . $model->resi . '.' . $bukti_pembayaran->extension;
                } else {
                    // Gunakan file bukti pembayaran yang sebelumnya disimpan
                    $model->bukti_pembayaran = $existingBuktiPembayaran;
                }

                // Simpan model
                $model->save();
                
                return $this->redirect(['view', 'id' => $model->resi]);
            }
        }


        // Ambil data provider
        $data_provider = (new \yii\db\Query())
        ->select(["*"])
        ->from("ms_provider")
        ->all();
        $list_provider = ArrayHelper::map($data_provider, 'id', 'nama');

        return $this->render('update', [
            'model' => $model,
            'list_provider' => $list_provider,
        ]);
    }

    /**
     * Deletes an existing TrProgressProvider model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {

        if (Yii::$app->user->isGuest) {
            return $this->redirect(array('/site/login'));
        } elseif (Yii::$app->user->identity->id_provider !== null) {

            return $this->redirect(array('/site/logout'));
        }

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TrProgressProvider model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return TrProgressProvider the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(array('/site/login'));
        } elseif (Yii::$app->user->identity->id_provider !== null) {

            return $this->redirect(array('/site/logout'));
        }

        if (($model = TrProgressProvider::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}