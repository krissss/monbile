<?php

namespace app\modules\user\controllers;

use app\models\forms\VideoSendForm;
use app\models\Games;
use app\models\Users;
use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        if ($user = Yii::$app->getSession()->get('user')) {
            $user_info = Users::findRelationById($user->uid);
            $video_send = new VideoSendForm();
            $games = Games::find()->all();
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
                    'user_info' => $user_info,
                    'video_send' => $video_send,
                    'games' => $games,
                    'message' => '发布成功',
                ]);
            }
            return $this->render('index', [
                'user_info' => $user_info,
                'video_send' => $video_send,
                'games' => $games,
            ]);
        }
        return $this->goHome();
    }

    public function actionVideos()
    {
        if ($user = Yii::$app->getSession()->get('user')) {
            $user_info = Users::findRelationById($user->uid);
            return $this->render('videos', [
                'user_info' => $user_info,
            ]);
        }
        return $this->goHome();
    }

    public function actionUpdateinfo()
    {
        if ($user = Yii::$app->getSession()->get('user')) {
            if (Yii::$app->request->post('updateinfo-return')) {
                exit;
            }
            if ($user_head = Yii::$app->request->get('head')) {
                $new_user = Users::findOne($user->uid);
                $new_user->head = $user_head;
                $new_user->update();
                Yii::$app->getSession()->set('user', $new_user);
                $user = Yii::$app->getSession()->get('user');
            }
            $model = Users::findOne($user->uid);
            $games = Games::find()->all();
            if ($model->load(Yii::$app->request->post())) {
                $model->update_date = date('Y-m-d H:i:s');
                $model->update();
                Yii::$app->getSession()->set('user', $model);
                Yii::$app->getSession()->get('user');
                return $this->redirect(['index']);
            } else {
                return $this->render('updateinfo', [
                    'model' => $model,
                    'games' => $games,
                ]);
            }
        }
        return $this->goHome();
    }

    public function actionChangehead()
    {
        if ($user = Yii::$app->getSession()->get('user')) {
            return $this->render('changehead');
        }
        return $this->goHome();
    }

    public function actionUpdatepaw()
    {
        if ($user = Yii::$app->getSession()->get('user')) {
            $model = Users::findOne($user->uid);
            if ($model->load(Yii::$app->request->post())) {
                if($model->password === $model->password_2){
                    $model->password = Users::password_encrypt($model->password);
                    $model->update();
                    Yii::$app->getSession()->set('user', $model);
                    Yii::$app->getSession()->get('user');
                    return $this->redirect(['index']);
                }else{
                    echo $model->password;
                    echo $model->password_2;
                    exit;
                    return $this->render('updatepaw', [
                        'model' => $model,
                    ]);
                }
            } else {
                return $this->render('updatepaw', [
                    'model' => $model,
                ]);
            }
        }
        return $this->goHome();
    }

    public function actionGoback()
    {
        return $this->goBack();
    }
}
