<?php

namespace app\modules\user\controllers;

use app\models\Collections;
use app\models\Comments;
use app\models\forms\VideoSendForm;
use app\models\Games;
use app\models\Users;
use app\models\Videos;
use app\modules\user\models\forms\UpdatePawForm;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\UploadedFile;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        if ($id = Yii::$app->request->get('id')) {
            $user = Yii::$app->getSession()->get('user');
            if ($user && $id == $user->uid) {
                //同以下没有id传参
                $video_send = new VideoSendForm();
                $games = Games::find()->all();
                if ($video_send->load(Yii::$app->request->post()) && $video_send->validate(['user_id', 'video_title', 'tags', 'game_id'])) {
                    $video_send->video_path = UploadedFile::getInstance($video_send, 'video_path');
                    if ($video_send->validate(['video_path']) && $video_send->video_path) {
                        $video_name = uniqid();
                        $video_send->video_path->saveAs('videos/' . $video_name . '.' . $video_send->video_path->extension);
                        $video_send->video_path = $video_name . '.' . $video_send->video_path->extension;
                        $video_send->videoSave();
                        Yii::$app->session->setFlash('success_message', '发布成功');
                        return $this->refresh();
                    }
                }
                return $this->render('index', [
                    'video_send' => $video_send,
                    'games' => $games,
                ]);
            }
            $other_user = Users::findRelationById($id);
            return $this->render('index', [
                'other_user' => $other_user,
            ]);
        }
        //如果没有id传参且用户已经登录
        if ($user = Yii::$app->getSession()->get('user')) {
            $video_send = new VideoSendForm();
            $games = Games::find()->all();
            if ($video_send->load(Yii::$app->request->post()) && $video_send->validate(['user_id', 'video_title', 'tags', 'game_id'])) {
                $video_send->video_path = UploadedFile::getInstance($video_send, 'video_path');
                if ($video_send->validate(['video_path']) && $video_send->video_path) {
                    $video_name = uniqid();
                    $video_send->video_path->saveAs('videos/' . $video_name . '.' . $video_send->video_path->extension);
                    $video_send->video_path = $video_name . '.' . $video_send->video_path->extension;
                    $video_send->videoSave();
                    Yii::$app->session->setFlash('success_message', '发布成功');
                    return $this->refresh();
                }
            }
            return $this->render('index', [
                'video_send' => $video_send,
                'games' => $games,
            ]);
        }
        return $this->redirect(Url::to(['/site/login']));
    }

    public function actionVideos()
    {
        if ($id = Yii::$app->request->get('id')) {
            $user = Yii::$app->getSession()->get('user');
            if ($user && $id == $user->uid) {
                //同以下没有id传参
                return $this->render('videos');
            }
            $other_user = Users::findRelationById($id);
            return $this->render('videos', [
                'other_user' => $other_user,
            ]);
        }
        //如果没有id传参且用户已经登录
        if ($user = Yii::$app->getSession()->get('user')) {
            return $this->render('videos');
        }
        return $this->redirect(Url::to(['/site/login']));
    }

    public function actionUpdateinfo()
    {
        if ($user = Yii::$app->getSession()->get('user')) {
            $games = Games::find()->all();
            if ($user->load(Yii::$app->request->post())) {
                //update_date用于区分用户是否修改密码，这里就不更新修改日期了
                //$model->update_date = date('Y-m-d H:i:s');
                $user->update();
                Yii::$app->session->setFlash('success_message', '修改成功');
                Yii::$app->session->setFlash('success_go_url', Url::to(['/user/default/index']));
                return $this->refresh();
            } else {
                return $this->render('updateinfo', [
                    'model' => $user,
                    'games' => $games,
                ]);
            }
        }
        return $this->redirect(Url::to(['/site/login']));
    }

    public function actionUpdatehead()
    {
        if ($user = Yii::$app->getSession()->get('user')) {
            if ($user_head = Yii::$app->request->get('head')) {
                $user->head = $user_head;
                $user->update();
                return $this->redirect(Url::to(['/user/default/index']));
            }
            return $this->render('updatehead');
        }
        return $this->redirect(Url::to(['/site/login']));
    }

    public function actionUpdatepaw()
    {
        if ($user = Yii::$app->getSession()->get('user')) {
            $model = new UpdatePawForm();
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                $user->password = Users::password_encrypt($model->password);
                $user->update_date = date('Y-m-d H:i:s');
                $user->update();
                Yii::$app->session->setFlash('success_message', '修改成功');
                Yii::$app->session->setFlash('success_go_url', Url::to(['/user/default/index']));
                return $this->refresh();
            } else {
                return $this->render('updatepaw', [
                    'model' => $model,
                ]);
            }
        }
        return $this->redirect(Url::to(['/site/login']));
    }

    public function actionSendcomment()
    {
        if ($user = Yii::$app->getSession()->get('user')) {
            $video_id = Yii::$app->request->post('video_id');
            $comment_content = Yii::$app->request->post('comment_content');
            $comment = new Comments();
            $comment->video_id = $video_id;
            $comment->user_id = $user -> uid;
            $comment->comment_content = $comment_content;
            $comment->comment_state = Comments::COMMENT_ENABLE;
            $comment->comment_date = date('Y-m-d H:i:s');
            if($comment->save() && Videos::updateCommentCountByVideoId($video_id)){
                return 'ok';
            }
            return 'error';
        }
        return $this->redirect(Url::to(['/site/login']));
    }

    public function actionShowcomments()
    {
        $video_id = Yii::$app->request->post('video_id');
        $comments = Comments::findCommentsByVideoId($video_id);
        $arrs = array();
        foreach( $comments as $comment){
            $arr = array(
                'uid'=>$comment->user->uid,
                'head'=>$comment->user->head,
                'nickname'=>$comment->user->nickname,
                'comment_content'=>$comment->comment_content,
                'comment_date'=>$comment->comment_date
            );
            array_push($arrs,$arr);
        }
        return json_encode($arrs);
    }

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
        return $this->redirect(Url::to(['/site/login']));
    }

    public function actionCollect(){
        if ($user = Yii::$app->getSession()->get('user')) {
            $video_id = Yii::$app->request->post('video_id');
            if(Collections::isExist($user->uid, $video_id)){
                return '已经收藏过';
            }else{
                $collection = new Collections();
                $collection->user_id = $user->uid;
                $collection->video_id = $video_id;
                $collection->collection_date = date('Y-m-d H:i:s');
                if(!$collection->save()){
                    return '保存收藏出错';
                }
                return 'ok';
            }
        }
        return $this->redirect(Url::to(['/site/login']));
    }

}
