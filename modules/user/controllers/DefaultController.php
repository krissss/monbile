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
        if (Yii::$app->getSession()->get('user')) {
            $user = Yii::$app->getSession()->get('user');
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
        if (Yii::$app->getSession()->get('user')) {
            $user = Yii::$app->getSession()->get('user');
            $user_info = Users::findRelationById($user->uid);
            return $this->render('videos', [
                'user_info' => $user_info,
            ]);
        }
        return $this->goHome();
    }
}
