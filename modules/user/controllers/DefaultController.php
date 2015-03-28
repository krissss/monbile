<?php

namespace app\modules\user\controllers;

use app\functions\Functions;
use app\models\Collections;
use app\models\Comments;
use app\models\forms\DateSearchForm;
use app\models\forms\TagSearchForm;
use app\models\forms\VideoSendForm;
use app\models\Hero;
use app\models\Message;
use app\models\Relations;
use app\models\Users;
use app\models\Videos;
use app\modules\user\models\forms\updatePawForm;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\UploadedFile;

class DefaultController extends Controller
{
    /**
     * 用户主页
     * @return string|\yii\web\Response
     */
    public function actionIndex()
    {
        //获取所有英雄并存入session
        if(!Yii::$app->getSession()->has(' heroes')){
            Yii::$app->getSession()->set('heroes',Hero::find()->all());
        }
        $id = Yii::$app->request->get('id');
        $user = Yii::$app->getSession()->get('user');
        //访问自己
        if (($user && $id == $user->uid) || ($user && $id == null)) {
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
            //自己首页展示
            //当用户没有发布过视频时，查询推荐关注
            if(count($user->videos)<1){
                $sameSchoolUser = Users::findSameSchoolUser(1,$user->uid);
                $relations_array = Relations::findAllBackIdInRelationsByFrontId($user->uid);
            }else{
                $sameSchoolUser = array();
                $relations_array = array();
            }
            return $this->render('index', [
                'video_send' => $video_send,
                'tagSearchForm' => $tagSearchForm,
                'dateSearchForm' => $dateSearchForm,
                'collections_array' => Collections::findAllVideoIdInCollectionsByUserId($user->uid),
                'sameSchoolUser' => $sameSchoolUser,
                'relations_array' => $relations_array,
            ]);
        }
        //访问他人
        if($id){
            $collections_array = array();
            $relations_array = array();
            //如果用户已登录
            if($user){
                $collections_array = Collections::findAllVideoIdInCollectionsByUserId($user->uid);
                //用户已登录标签搜索
                $tagSearchForm = new TagSearchForm();
                if ($tagSearchForm->load(Yii::$app->request->post())) {
                    return $this->render("//site/search",[
                        'search_type' => $tagSearchForm->search_type,
                        'search_content' => $tagSearchForm->search_content,
                        'collections_array' => $collections_array,
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
                        'collections_array' => $collections_array,
                        'videos_info' => Videos::findVideosByDate($dateSearchForm->date_start,$dateSearchForm->date_end,$dateSearchForm->search_type)
                    ]);
                }
                $relations_array = Relations::findAllBackIdInRelationsByFrontId($user->uid);
            }
            //用户未登录
            //用户未登录搜索
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
            //无论用户登录与否，其他人首页展示
            return $this->render('index', [
                'tagSearchForm' => $tagSearchForm,
                'dateSearchForm' => $dateSearchForm,
                'other_user' => Users::findOne($id),
                'relations_array' => $relations_array,
                'sameSchoolUser' => array(),
                'collections_array' => $collections_array,
            ]);
        }
        //未登录且试图访问自己
        return $this->redirect(Url::to(['/site/login']));
    }

    /**
     * 视频页面
     * @return string|\yii\web\Response
     */
    public function actionVideos()
    {
        $id = Yii::$app->request->get('id');
        $user = Yii::$app->getSession()->get('user');
        //访问自己
        if (($user && $id == $user->uid) || ($user && $id == null)) {
            return $this->render('videos');
        }
        //访问他人
        if($id){
            $relations_array = array();
            //如果用户已登录
            if($user){
                $relations_array = Relations::findAllBackIdInRelationsByFrontId($user->uid);
            }
            $other_user = Users::findOne($id);
            return $this->render('videos', [
                'other_user' => $other_user,
                'relations_array' => $relations_array,
            ]);
        }
        //未登录且试图访问自己
        return $this->redirect(Url::to(['/site/login']));
    }

    /**
     * 收藏页面
     * @return string|\yii\web\Response
     */
    public function actionCollections()
    {
        $id = Yii::$app->request->get('id');
        $user = Yii::$app->getSession()->get('user');
        //访问自己
        if (($user && $id == $user->uid) || ($user && $id == null)) {
            $collections_array = Collections::findAllVideoIdInCollectionsByUserId($user->uid);
            return $this->render('collections',[
                'collections_array' => $collections_array,
            ]);
        }
        //访问他人
        if($id){
            $relations_array = array();
            $collections_array = array();
            //如果用户已登录
            if($user){
                $relations_array = Relations::findAllBackIdInRelationsByFrontId($user->uid);
                $collections_array = Collections::findAllVideoIdInCollectionsByUserId($user->uid);
            }
            $other_user = Users::findOne($id);
            return $this->render('collections', [
                'other_user' => $other_user,
                'relations_array' => $relations_array,
                'collections_array' => $collections_array,
            ]);
        }
        //未登录且试图访问自己
        return $this->redirect(Url::to(['/site/login']));
    }

    /**
     * 关注页面
     * @return string|\yii\web\Response
     */
    public function actionRelationsFront(){
        $id = Yii::$app->request->get('id');
        $user = Yii::$app->getSession()->get('user');
        //访问自己
        if (($user && $id == $user->uid) || ($user && $id == null)) {
            $relations_array = Relations::findAllBackIdInRelationsByFrontId($user->uid);
            return $this->render('relationsFront', [
                'relations_array' => $relations_array,
            ]);
        }
        //访问他人
        if($id){
            $relations_array = array();
            //如果用户已登录
            if($user){
                $relations_array = Relations::findAllBackIdInRelationsByFrontId($user->uid);
            }
            $other_user = Users::findOne($id);
            return $this->render('relationsFront', [
                'other_user' => $other_user,
                'relations_array' => $relations_array,
            ]);
        }
        //未登录且试图访问自己
        return $this->redirect(Url::to(['/site/login']));
    }

    /**
     * 粉丝页面
     * @return string|\yii\web\Response
     */
    public function actionRelationsBack(){
        $id = Yii::$app->request->get('id');
        $user = Yii::$app->getSession()->get('user');
        //访问自己
        if (($user && $id == $user->uid) || ($user && $id == null)) {
            $relations_array = Relations::findAllBackIdInRelationsByFrontId($user->uid);
            return $this->render('relationsBack', [
                'relations_array' => $relations_array,
            ]);
        }
        //访问他人
        if($id){
            $relations_array = array();
            //如果用户已登录
            if($user){
                $relations_array = Relations::findAllBackIdInRelationsByFrontId($user->uid);
            }
            $other_user = Users::findOne($id);
            return $this->render('relationsBack', [
                'other_user' => $other_user,
                'relations_array' => $relations_array,
            ]);
        }
        //未登录且试图访问自己
        return $this->redirect(Url::to(['/site/login']));
    }

    public function actionMessage(){
        if ($user = Yii::$app->getSession()->get('user')) {
            $messagesUnRead = Message::findMessageUnRead($user->uid);
            foreach($messagesUnRead as $message){
                $message->message_state = Message::MESSAGE_STATE_READ;
                $message->update();
            }
            $messagesTotal = Message::find()->where(['to_user_id'=>$user->uid])->orderBy(['message_date'=>SORT_DESC])->all();
            return $this->render('message',[
                'messagesUnRead' => $messagesUnRead,
                'messagesTotal' =>$messagesTotal,
            ]);
        }
        return $this->redirect(Url::to(['/site/login']));
    }

    /**
     * 修改信息页面
     * @return string|\yii\web\Response
     */
    public function actionUpdateInfo()
    {
        if ($user = Yii::$app->getSession()->get('user')) {
            if ($user->load(Yii::$app->request->post())) {
                //update_date用于区分用户是否修改密码，这里就不更新修改日期了
                //$model->update_date = date('Y-m-d H:i:s');
                $user->update();
                Yii::$app->session->setFlash('success_message', '修改成功');
                Yii::$app->session->setFlash('success_go_url', Url::to(['/user/default/index']));
                return $this->refresh();
            } else {
                return $this->render('updateInfo', [
                    'model' => $user,
                ]);
            }
        }
        return $this->redirect(Url::to(['/site/login']));
    }

    /**
     * 修改头像页面
     * @return string|\yii\web\Response
     */
    public function actionUpdateHead()
    {
        if ($user = Yii::$app->getSession()->get('user')) {
            if ($user_head = Yii::$app->request->get('head')) {
                $dir = $_SERVER['DOCUMENT_ROOT'] . '\heads';
                if(!strstr($user->head,'head') && file_exists($dir.'/'.$user->head)){
                    rename($dir.'/'.$user->head, $dir.'/delete_'.$user->head);
                }
                $user->head = $user_head;
                $user->update();
                return $this->redirect(Url::to(['/user/default/index']));
            }
            return $this->render('updateHead');
        }
        return $this->redirect(Url::to(['/site/login']));
    }

    /**
     * 修改密码页面
     * @return string|\yii\web\Response
     */
    public function actionUpdatePaw()
    {
        if ($user = Yii::$app->getSession()->get('user')) {
            $model = new updatePawForm();
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                $user->password = Users::password_encrypt($model->password);
                $user->update_date = date('Y-m-d H:i:s');
                $user->update();
                Yii::$app->session->setFlash('success_message', '修改成功');
                Yii::$app->session->setFlash('success_go_url', Url::to(['/user/default/index']));
                return $this->refresh();
            } else {
                return $this->render('updatePaw', [
                    'model' => $model,
                ]);
            }
        }
        return $this->redirect(Url::to(['/site/login']));
    }

    /**
     * ajax请求发送评论
     * @return string
     */
    public function actionSendComment()
    {
        if ($user = Yii::$app->getSession()->get('user')) {
            $video_id = Yii::$app->request->post('video_id');
            $parent_id = Yii::$app->request->post('parent_id');
            $to_user_id = Yii::$app->request->post('to_user_id');
            $comment_content = Yii::$app->request->post('comment_content');
            $comment = new Comments();
            $comment->video_id = $video_id;
            $comment->user_id = $user -> uid;
            $comment->parent_id = $parent_id;
            $comment->comment_content = $comment_content;
            $comment->comment_state = Comments::COMMENT_ENABLE;
            $comment->comment_date = date('Y-m-d H:i:s');
            if($to_user_id == $user->uid){//若发送者是给自己评论的，则报讯消息已读
                if($comment->save() && Videos::updateCommentCountByVideoId($video_id)){
                    if(Message::sendMessage($user->uid,$to_user_id,'来自评论',$comment->comment_content,$video_id,$comment->cid,Message::MESSAGE_STATE_READ)){
                        return 'ok';
                    }else{
                        return '发送消息出错';
                    }
                }
            }else{//否则，消息未读
                if($comment->save() && Videos::updateCommentCountByVideoId($video_id)){
                    if(Message::sendMessage($user->uid,$to_user_id,'来自评论',$comment->comment_content,$video_id,$comment->cid)){
                        return 'ok';
                    }else{
                        return '发送消息出错';
                    }
                }
            }
            return 'error';
        }
        return $this->redirect(Url::to(['/site/login']));
    }

    /**
     * ajax请求查询评论
     * @return string
     */
    public function actionShowComments()
    {
        $video_id = Yii::$app->request->post('video_id');
        $comments = Comments::findCommentsByVideoId($video_id);
        $arrs = array();
        foreach( $comments as $comment){
            $arr = array(
                'uid'=>$comment->user->uid,
                'head'=>$comment->user->head,
                'nickname'=>$comment->user->nickname,
                'cid'=>$comment->cid,
                'comment_content'=>$comment->comment_content,
                'comment_date'=>$comment->comment_date,
                'parent_id' =>$comment->parent_id,
            );
            array_push($arrs,$arr);
        }
        return json_encode($arrs);
    }

    /**
     * ajax请求点赞
     * @return string
     */
    public function actionPraise()
    {
        if ($user = Yii::$app->getSession()->get('user')) {
            $video_id = Yii::$app->request->post('video_id');
            $session_praise = Yii::$app->getSession()->get('praise_'.$video_id);
            //每半小时只能赞一次
            if(!$session_praise || time()>$session_praise+60*30) {
                if(Videos::updatePraiseCountByVideoId($video_id)){
                    Yii::$app->getSession()->set('praise_'.$video_id, time());
                    return 'ok';
                }
            }
            return '每半小时只能赞1次';
        }
        return 'no_login';
    }

    /**
     * ajax请求收藏和取消收藏
     * @return string
     * @throws \Exception
     */
    public function actionCollect(){
        if ($user = Yii::$app->getSession()->get('user')) {
            $video_id = Yii::$app->request->post('video_id');
            if($collection = Collections::isExist($user->uid, $video_id)){
                if(!$collection->delete()){
                    return '取消收藏出错，请稍后再试';
                }
                $email = $user->email;
                Yii::$app->getSession()->remove('user');
                Yii::$app->getSession()->set('user',Users::findByEmail($email));
                return 'ok_delete';
            }else{
                $collection = new Collections();
                $collection->user_id = $user->uid;
                $collection->video_id = $video_id;
                $collection->collection_date = date('Y-m-d H:i:s');
                if(!$collection->save()){
                    return '保存收藏出错，请稍后再试';
                }
                $email = $user->email;
                Yii::$app->getSession()->remove('user');
                Yii::$app->getSession()->set('user',Users::findByEmail($email));
                return 'ok';
            }
        }
        return 'no_login';
    }

    /**
     * ajax请求删除视频
     * @return string|\yii\web\Response
     * @throws \Exception
     */
    public function actionDeleteVideo(){
        if ($user = Yii::$app->getSession()->get('user')) {
            $video_id = Yii::$app->request->post('video_id');
            if($video = Videos::findOne($video_id)){
                $dir = $_SERVER['DOCUMENT_ROOT'] . '\videos';
                if(file_exists($dir.'/'.$video->video_path)){
                    rename($dir.'/'.$video->video_path, $dir.'/delete_'.$video->video_path);
                    Collections::deleteAll(['video_id'=>$video_id]);
                    $video->delete();
                    $email = $user->email;
                    Yii::$app->getSession()->remove('user');
                    Yii::$app->getSession()->set('user',Users::findByEmail($email));
                    return 'ok';
                }else{
                    return '删除文件错误，请联系管理员';
                }
            }
            return '删除出错，请稍后再试';
        }
        return $this->redirect(Url::to(['/site/login']));
    }

    /**
     * ajax请求关注和取消关注
     * @return string
     * @throws \Exception
     */
    public function actionFollow(){
        if ($user = Yii::$app->getSession()->get('user')) {
            $user_id = Yii::$app->request->post('user_id');
            if($relation = Relations::isExist($user->uid, $user_id)){
                if($relation->relation_state == Relations::RELATION_STABLE){//下面做取消关注
                    $relation->relation_state = Relations::RELATION_DISABLE;
                    $message = 'ok_delete';
                }else if($relation->relation_state == Relations::RELATION_DISABLE){//下面做关注
                    $relation->relation_state = Relations::RELATION_STABLE;
                    $message = 'ok';
                }else{//不存在的状态
                    return '非法状态,请联系管理员';
                }
                if(!$relation->update()){
                    return '关注出错，请稍后再试';
                }
                $email = $user->email;
                Yii::$app->getSession()->remove('user');
                Yii::$app->getSession()->set('user',Users::findByEmail($email));
                Yii::$app->getSession()->remove('users_hot');
                Yii::$app->getSession()->set('users_hot',Users::findHotUsers());
                return $message;
            }else{
                $relation = new Relations();
                $relation->relation_state = Relations::RELATION_STABLE;
                $relation->front_id = $user->uid;
                $relation->back_id = $user_id;
                if(!$relation->save()){
                    return '关注出错，请稍后再试';
                }
                $email = $user->email;
                Yii::$app->getSession()->remove('user');
                Yii::$app->getSession()->set('user',Users::findByEmail($email));
                Yii::$app->getSession()->remove('users_hot');
                Yii::$app->getSession()->set('users_hot',Users::findHotUsers());
                return 'ok';
            }
        }
        return 'no_login';
    }

}
