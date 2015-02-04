<?php

namespace app\controllers;

use app\models\forms\RegisterForm;
use app\models\forms\VideoSendForm;
use app\models\Users;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\forms\LoginForm;
use app\models\forms\ContactForm;
use yii\web\UploadedFile;

class SiteController extends Controller
{
    /*    public function behaviors()
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
        }*/

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

    public function actionIndex()
    {
        if (Yii::$app->getSession()->get('user')) {
            $video_send = new VideoSendForm();
            return $this->render('index', [
                'video_send' => $video_send,
            ]);
        }
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $user = $model->login()) {
            Yii::$app->getSession()->set('user', $user);
            return $this->goHome();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->getSession()->removeAll();
        Yii::$app->getSession()->destroy();
        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionRegister()
    {
        $model = new RegisterForm();
        if ($model->load(Yii::$app->request->post()) && $model->sendPassword()) {
            if ($user = $model->register()) {
                return $this->redirect(Yii::$app->getRequest()->getBaseUrl() . 'index.php?r=site/login');
            } else {
                return $this->render('error', [
                    'name' => '注册出错',
                    'message' => '验证出错',
                ]);
            }
        }

        return $this->render('register', [
            'model' => $model,
        ]);
    }

    public function actionVideoSend()
    {
        $video_send = new VideoSendForm();

        if ($video_send->load(Yii::$app->request->post()) && $video_send->validate(['user_id', 'video_title', 'tags', 'game_id'])) {
            $video_send->video_path = UploadedFile::getInstance($video_send, 'video_path');
            if ($video_send->validate(['video_path']) && $video_send->video_path) {
                $video_name = uniqid();
                $video_send->video_path->saveAs('videos/' . $video_name . '.' . $video_send->video_path->extension);
                $video_send->video_path = $video_name . '.' . $video_send->video_path->extension;
                $video_send->videoSave();
                return $this->refresh('&state=ok');
            }
        }
        $state = Yii::$app->request->get('state');
        if ($state == 'ok') {
            return $this->render('index', [
                'video_send' => $video_send,
                'message' => '发布成功',
            ]);
        }
        return $this->render('index', [
            'video_send' => $video_send,
        ]);

    }


}
