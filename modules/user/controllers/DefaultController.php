<?php

namespace app\modules\user\controllers;

use Yii;
use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        $request = Yii::$app->request;
        $uid = $request->get('uid');
        return $this->render('index',['uid' => $uid]);
    }

    public function actionVideos()
    {
        $request = Yii::$app->request;
        $uid = $request->get('uid');
        return $this->render('videos',['uid' => $uid]);
    }
}
