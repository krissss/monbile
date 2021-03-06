<?php

namespace app\controllers;

use app\functions\Functions;
use app\models\Collections;
use app\models\forms\DateSearchForm;
use app\models\forms\LoginForm;
use app\models\forms\RegisterForm;
use app\models\forms\TagSearchForm;
use app\models\forms\VideoSendForm;
use app\models\Games;
use app\models\Hero;
use app\models\Relations;
use app\models\Tags;
use app\models\Tops;
use app\models\Users;
use app\models\Videos;
use Yii;
use yii\web\Controller;
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
            ]
        ];
    }

    /**
     * 网站首页
     * @return string|\yii\web\Response
     */
    public function actionIndex()
    {
        //获取所有英雄并存入session
        if(!Yii::$app->getSession()->has(' heroes')){
            Yii::$app->getSession()->set('heroes',Hero::find()->all());
        }
        //用户已登录
        if ($user = Yii::$app->getSession()->get('user')) {
            //用户发视频
            $video_send = new VideoSendForm();
            if ($video_send->load(Yii::$app->request->post()) && $video_send->validate()) {
                if($video_send->videoSave($user->uid)){
                    $email = $user->email;
                    Yii::$app->getSession()->remove('user');
                    Yii::$app->getSession()->set('user',Users::findByEmail($email));
                    Yii::$app->session->setFlash('success_message','发布成功');
                    return $this->refresh();
                }else{
                    Yii::$app->session->setFlash('wrong_message','出现一些问题，您可以稍后重试');
                    return $this->refresh();
                }
            }
            //用户已登录标签搜索
            $tagSearchForm = new TagSearchForm();
            if ($tagSearchForm->load(Yii::$app->request->post())) {
                return $this->render("//site/search",[
                    'search_type' => $tagSearchForm->search_type,
                    'search_content' => $tagSearchForm->search_content,
                    'collections_array' => Collections::findAllVideoIdInCollectionsByUserId($user->uid),
                    'videos_info' => Videos::findVideosByTag($tagSearchForm->search_content,$tagSearchForm->search_type)
                ]);
            }
            //用户已登录时间搜索
            $dateSearchForm = new DateSearchForm();
            if ($dateSearchForm->load(Yii::$app->request->post())) {
                return $this->render("//site/search",[
                    'date_start' => $dateSearchForm->date_start,
                    'date_end' => $dateSearchForm->date_end,
                    'search_type' => $dateSearchForm->search_type,
                    'collections_array' => Collections::findAllVideoIdInCollectionsByUserId($user->uid),
                    'videos_info' => Videos::findVideosByDate($dateSearchForm->date_start,$dateSearchForm->date_end,$dateSearchForm->search_type)
                ]);
            }
            //首页展示
            return $this->render('index', [
                'tagSearchForm' => $tagSearchForm,
                'dateSearchForm' => $dateSearchForm,
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
        //用户未登录标签搜索
        $tagSearchForm = new TagSearchForm();
        if ($tagSearchForm->load(Yii::$app->request->post())) {
            return $this->render("//site/search",[
                'search_type' => $tagSearchForm->search_type,
                'search_content' => $tagSearchForm->search_content,
                'collections_array' => array(),
                'videos_info' => Videos::findVideosByTag($tagSearchForm->search_content,$tagSearchForm->search_type)
            ]);
        }
        //用户未登录时间搜索
        $dateSearchForm = new DateSearchForm();
        if ($dateSearchForm->load(Yii::$app->request->post())) {
            return $this->render("//site/search",[
                'date_start' => $dateSearchForm->date_start,
                'date_end' => $dateSearchForm->date_end,
                'search_type' => $dateSearchForm->search_type,
                'collections_array' => array(),
                'videos_info' => Videos::findVideosByDate($dateSearchForm->date_start,$dateSearchForm->date_end,$dateSearchForm->search_type)
            ]);
        }
        //首页展示
        return $this->render('index', [
            'tagSearchForm' => $tagSearchForm,
            'dateSearchForm' => $dateSearchForm,
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
                'tag_id' => $id,
                'collections_array' => $collections_array,
                'videos_info' => Videos::findVideosByHeroId($id)
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

    /**
     * 获取更多视频
     * @return string
     */
    public function actionGetMore(){
        $type = Yii::$app->request->get('type');
        $offset = Yii::$app->request->get('offset');
        $date_start = Yii::$app->request->get('date_start');
        $date_end = Yii::$app->request->get('date_end');
        $search_type = Yii::$app->request->get('search_type');
        $search_content = Yii::$app->request->get('search_content');
        $tag_id = Yii::$app->request->get('tag_id');
        $videos_info = null;
        $tag_relations = null;
        if($type == 'one_hour'){
            $videos_info = Videos::findOneHourVideos($offset);
        }elseif($type == 'one_day'){
            $videos_info = Videos::findOneDayVideos($offset);
        }elseif($type == 'search_date'){
            $videos_info = Videos::findVideosByDate($date_start,$date_end,$search_type,$offset);
        }elseif($type == 'search_tag'){
            $videos_info = Videos::findVideosByTag($search_content,$search_type,$offset);
        }elseif($type == 'search_tag_cloud'){
            $videos_info = Videos::findVideosByTagId($tag_id,$offset);
        }
        //如果用户已登录
        $collections_array = array();
        if ($user = Yii::$app->getSession()->get('user')) {
            $collections_array = Collections::findAllVideoIdInCollectionsByUserId($user->uid);
        }
        return $this->renderPartial('moreVideos', [
            'offset' => $offset,
            'type' => $type,
            'date_start' => $date_start,
            'date_end' => $date_end,
            'search_type' => $search_type,
            'search_content' => $search_content,
            'tag_id' => $tag_id,
            'collections_array' => $collections_array,
            'videos_info' => $videos_info,
        ]);
    }

    /**
     * 单个视频显示页面::还没完全完成//TODO
     * @return string
     */
    public function actionVideo(){
        $video_id = Yii::$app->request->get('id');
        $video_info = Videos::findOne($video_id);
        //如果用户已登录
        $collections_array = array();
        if ($user = Yii::$app->getSession()->get('user')) {
            $collections_array = Collections::findAllVideoIdInCollectionsByUserId($user->uid);
        }
        return $this->render('video',[
            'video_info' => $video_info,
            'collections_array' => $collections_array
        ]);
    }
}
