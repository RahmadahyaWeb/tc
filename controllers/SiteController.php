<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */

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
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->render('index');
        } elseif (isset(Yii::$app->user->identity->id_provider)) {
            Yii::$app->user->logout();
            return $this->redirect(array('/site/login'));
            // return "berhasil";  
        } else {
            return $this->render('index');
        }
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->login()) {
                if ($model->user->active == '0') {
                    return $this->redirect(array('/usermanage/gantipass'));
                } else if ($model->user->active == '1') {
                    return $this->goBack();
                } else {
                    $model->addError('username', 'User Anda tidak aktif!');
                }
            } else {
                $data = Yii::$app->request->post();

                $user_id = $data['LoginForm']['username'];
                $conn = Yii::$app->db_hrd;
                $command = $conn->createCommand("SELECT PASSWORD FROM MS_USER WHERE USER_ID = :user_id");
                $command->bindParam(':user_id', $user_id);
                $dataUser = $command->queryOne();

                if ($dataUser) {
                    $decrypt = $this->decryptOpenSSL3DES($dataUser['PASSWORD']);
                    $password = substr($decrypt, strlen($user_id));
                    if ($data['LoginForm']['password'] == $password) {
                        if ($model->loginHRD()) {
                            return $this->goBack();
                        }
                    }
                }
            }
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function encryptOpenSSL3DES($text)
    {
        // Secret Key
        $key1 = "Je ne vous oublie pas";
        $key2 = "!@#$%!@#$%";
        $key = substr($key1 . $key2, 0, 24);

        // Initialization Vector
        $iv = "";
        $array_iv = array(12, 241, 10, 21, 90, 74, 11, 39);
        foreach ($array_iv as $value_iv) {
            $iv .= chr($value_iv);
        }

        $cipher = "des-ede3-cbc"; // 3DES in CBC mode
        $options = OPENSSL_RAW_DATA;
        $encrypt_text = openssl_encrypt($text, $cipher, $key, $options, $iv);

        return base64_encode($encrypt_text);
    }

    public function decryptOpenSSL3DES($encrypted_text)
    {
        // Secret Key
        $key1 = "Je ne vous oublie pas";
        $key2 = "!@#$%!@#$%";
        $key = substr($key1 . $key2, 0, 24);

        // Initialization Vector
        $iv = "";
        $array_iv = array(12, 241, 10, 21, 90, 74, 11, 39);
        foreach ($array_iv as $value_iv) {
            $iv .= chr($value_iv);
        }

        $encrypted_text = base64_decode($encrypted_text);
        $cipher = "des-ede3-cbc"; // 3DES in CBC mode
        $options = OPENSSL_RAW_DATA;
        $decrypted_text = openssl_decrypt($encrypted_text, $cipher, $key, $options, $iv);

        return $decrypted_text;
    }
}
