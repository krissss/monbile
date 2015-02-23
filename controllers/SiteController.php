<?php

namespace app\controllers;

use app\models\Collections;
use app\models\forms\RegisterForm;
use app\models\forms\SearchForm;
use app\models\forms\VideoSendForm;
use app\models\Games;
use app\models\Relations;
use app\models\Tags;
use app\models\Tops;
use app\models\Users;
use app\models\Videos;
use Yii;
use yii\web\Controller;
use app\models\forms\LoginForm;
use app\models\forms\ContactForm;
use yii\web\UploadedFile;

class SiteController extends Controller
{
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
     * 网站首页
     * @return string|\yii\web\Response
     */
    public function actionIndex()
    {
        //获取热门标签并将其放入session
        if(!Yii::$app->getSession()->has('tags_hot')){
            Yii::$app->getSession()->set('tags_hot',Tags::findHotTags());
        }
        //获取热门人物并将其放入session
        if(!Yii::$app->getSession()->has('users_hot')){
            Yii::$app->getSession()->set('users_hot',Users::findHotUsers());
        }
        //用户已登录
        if ($user = Yii::$app->getSession()->get('user')) {
            //用户发视频
            $video_send = new VideoSendForm();
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
            //用户已登录搜索
            $searchForm = new SearchForm();
            if ($searchForm->load(Yii::$app->request->post())) {
                return $this->render("//site/search",[
                    'collections_array' => Collections::findAllVideoIdInCollectionsByUserId($user->uid),
                    'videos_info' => Videos::findVideosByTag($searchForm->search_content,$searchForm->search_type)
                ]);
            }
            //首页展示
            return $this->render('index', [
                'searchForm' => $searchForm,
                'video_send' => $video_send,
                'videos_one_hour' => Videos::findOneHourVideos(),
                'videos_one_day' => Videos::findOneDayVideos(),
                'one_week_top' => Tops::findTopVideosForUser(date("Y-m-d",strtotime("-1 week Monday")),Tops::TOP_TYPE_WEEK),
                'one_month_top' => Tops::findTopVideosForUser(date("Y-m-01"),Tops::TOP_TYPE_MONTH),
                'one_year_top' => Tops::findTopVideosForUser(date("Y-01-01"),Tops::TOP_TYPE_YEAR),
                'collections_array' => Collections::findAllVideoIdInCollectionsByUserId($user->uid),
                'relations_array' => Relations::findAllBackIdInRelationsByFrontId($user->uid),
            ]);
        }
        //用户未登录
        //用户未登录搜索
        $searchForm = new SearchForm();
        if ($searchForm->load(Yii::$app->request->post())) {
            return $this->render("//site/search",[
                'collections_array' => array(),
                'videos_info' => Videos::findVideosByTag($searchForm->search_content,$searchForm->search_type)
            ]);
        }
        //首页展示
        return $this->render('index', [
            'searchForm' => $searchForm,
            'videos_one_hour' => Videos::findOneHourVideos(),
            'videos_one_day' => Videos::findOneDayVideos(),
            'one_week_top' => Tops::findTopVideosForUser(date("Y-m-d",strtotime("-1 week Monday")),Tops::TOP_TYPE_WEEK),
            'one_month_top' => Tops::findTopVideosForUser(date("Y-m-01"),Tops::TOP_TYPE_MONTH),
            'one_year_top' => Tops::findTopVideosForUser(date("Y-01-01"),Tops::TOP_TYPE_YEAR),
            'relations_array' => array(),
            'collections_array' => array(),
        ]);
    }

    /**
     * 登录
     * @return string|\yii\web\Response
     */
    public function actionLogin()
    {
        $model = new LoginForm();
        $model->load(Yii::$app->request->post());
        if ($model->load(Yii::$app->request->post()) && $user = $model->login()) {
            $session = Yii::$app->getSession();
            $session->set('user', $user);
            $session->set('games', Games::find()->all());
            return $this->redirect(['/user/default/index']);
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * 注销登录
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->getSession()->removeAll();
        Yii::$app->getSession()->destroy();
        return $this->goHome();
    }

    /**
     * 注册
     * @return string|\yii\web\Response
     */
    public function actionRegister()
    {
        $model = new RegisterForm();
        if ($model->load(Yii::$app->request->post()) && $model->sendPassword()) {
            if ($user = $model->register()) {
                Yii::$app->session->setFlash('success_message','发送邮件成功！');
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

    /**
     * 点击标签进行搜索
     * @return string|\yii\web\Response
     */
    public function actionSearch()
    {
        if ($id = Yii::$app->request->get('id')) {
            $collections_array = array();
            //如果用户已登录
            if ($user = Yii::$app->getSession()->get('user')) {
                $collections_array = Collections::findAllVideoIdInCollectionsByUserId($user->uid);
            }
            return $this->render('search',[
                'collections_array' => $collections_array,
                'videos_info' => Videos::findVideosByTagId($id)
            ]);
        }else{
            return $this->goHome();
        }
    }

    /**
     * 榜单列表
     * @return string
     */
    public function actionTopList(){
        return $this->render('topList',[
            'tops_date_type' => Tops::findAllTopTypeDateForAdmin(),
            'tops_array' => Tops::findAllTopNotPassedForAdmin()
        ]);
    }

    /**
     * 单个榜单视频展示
     * @return string
     */
    public function actionTopVideos(){
        $top_type = Yii::$app->request->get('type');
        $top_date = Yii::$app->request->get('date');
        $tops_info = Tops::findTopVideosForAdmin($top_date,$top_type);
        $collections_array = array();
        //如果用户已登录
        if ($user = Yii::$app->getSession()->get('user')) {
            $collections_array = Collections::findAllVideoIdInCollectionsByUserId($user->uid);
        }
        return $this->render('topVideos',[
            'tops_info' => $tops_info,
            'collections_array' => $collections_array,
        ]);
    }
}
