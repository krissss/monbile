<?php

namespace app\modules\user\controllers;

use app\models\forms\VideoSendForm;
use app\models\Games;
use app\models\Users;
use app\modules\user\models\forms\UpdatePawForm;
use Yii;
use yii\helpers\Url;
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
                    Yii::$app->session->setFlash('success_message','发布成功');
                    return $this->refresh();
                }
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
            $games = Games::find()->all();
            if ($user->load(Yii::$app->request->post())) {
                //update_date用于区分用户是否修改密码，这里就不更新修改日期了
                //$model->update_date = date('Y-m-d H:i:s');
//                var_dump($user->currentplace);
//                exit;
                $user->update();
                Yii::$app->session->setFlash('success_message','修改成功');
                Yii::$app->session->setFlash('success_go_url',Url::to(['/user/default/index']));
                return $this->refresh();
            } else {
                return $this->render('updateinfo', [
                    'model' => $user,
                    'games' => $games,
                ]);
            }
        }
        return $this->goHome();
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
        return $this->goHome();
    }

    public function actionUpdatepaw()
    {
        if ($user = Yii::$app->getSession()->get('user')) {
            $model = new UpdatePawForm();
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                $user->password = Users::password_encrypt($model->password);
                $user->update_date = date('Y-m-d H:i:s');
                $user->update();
                Yii::$app->session->setFlash('success_message','修改成功');
                Yii::$app->session->setFlash('success_go_url',Url::to(['/user/default/index']));
                return $this->refresh();
            } else {
                return $this->render('updatepaw', [
                    'model' => $model,
                ]);
            }
        }
        return $this->goHome();
    }

}
