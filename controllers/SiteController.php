<?php

namespace app\controllers;

use app\models\Collections;
use app\models\forms\RegisterForm;
use app\models\forms\VideoSendForm;
use app\models\Games;
use app\models\Relations;
use app\models\Tags;
use app\models\Users;
use app\models\Videos;
use Yii;
use yii\web\Controller;
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
        $videos_one_hour = Videos::findOneHourVideos();
        $videos_on_day = Videos::findOneDayVideos();
        $relations_array = array();
        if(!Yii::$app->getSession()->has('tags_hot')){
            Yii::$app->getSession()->set('tags_hot',Tags::findHotTags());
        }
        if(!Yii::$app->getSession()->has('users_hot')){
            Yii::$app->getSession()->set('users_hot',Users::findHotUsers());
        }
        if ($user = Yii::$app->getSession()->get('user')) {
            $video_send = new VideoSendForm();
            $collections_array = Collections::findAllVideoIdInCollectionsByUserId($user->uid);
            $relations_array = Relations::findAllBackIdInRelationsByFrontId($user->uid);
            if ($video_send->load(Yii::$app->request->post()) && $video_send->validate(['user_id', 'video_title', 'tags', 'game_id'])) {
                $video_send->video_path = UploadedFile::getInstance($video_send, 'video_path');
                if ($video_send->validate(['video_path']) && $video_send->video_path) {
                    $video_name = uniqid();
                    $video_send->video_path->saveAs('videos/' . $video_name . '.' . $video_send->video_path->extension);
                    $video_send->video_path = $video_name . '.' . $video_send->video_path->extension;
                    $video_send->videoSave();
                    $email = $user->email;
                    Yii::$app->getSession()->remove('user');
                    Yii::$app->getSession()->set('user',Users::findByEmail($email));
                    Yii::$app->session->setFlash('success_message','发布成功');
                    return $this->refresh();
                }
            }
            return $this->render('index', [
                'videos_one_hour' => $videos_one_hour,
                'videos_one_day' => $videos_on_day,
                'video_send' => $video_send,
                'collections_array' => $collections_array,
                'relations_array' => $relations_array,
            ]);
        }
        return $this->render('index', [
            'videos_one_hour' => $videos_one_hour,
            'videos_one_day' => $videos_on_day,
            'relations_array' => $relations_array,
        ]);
    }

    public function actionLogin()
    {
        $model = new LoginForm();
        $model->load(Yii::$app->request->post());
        if ($model->load(Yii::$app->request->post()) && $user = $model->login()) {
            Yii::$app->getSession()->set('user', $user);
            Yii::$app->getSession()->set('games', Games::find()->all());
            return $this->redirect(['/user/default/index']);
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
        return $this->render('about',[
            'videos' => Users::findHotUsers(),
        ]);
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


}
