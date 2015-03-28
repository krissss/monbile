<?php

namespace app\modules\user\controllers;

use app\functions\Functions;
use app\models\Praise;
use app\models\Videos;
use Yii;
use yii\web\Controller;

class AjaxController extends Controller
{
    /**
     * 盖章，点赞
     * @return string
     */
    public function actionSignSeal(){
        if ($user = Yii::$app->getSession()->get('user')) {
            $request = Yii::$app->request;
            $user_id = $user->uid;
            $seal = $request->post('seal');
            $video_id = $request->post('video_id');
            if($user_id && $seal && $video_id){
                $video = Videos::findOne($video_id);
                if($user_id == $video->user_id){
                    return "自己不能赞自己的视频，把机会留给他人吧~";
                }
                if(Praise::isPraised($user_id,$video_id)){
                    return "您已经赞过该视频";
                }
                if(!Praise::savePraise($user_id,$video_id)) {
                    return "保存数据出错，请稍候再试";
                }
                //盖章
                $thumbnailName = $video->video_thumbnail;
                $seal_size = rand(80,120);
                $xy = Functions::getXY($thumbnailName);
                if($xy!=null){
                    $array = explode(',',$xy);
                    $x = $array[0];
                    $y = $array[1];
                    Functions::signToImage($user_id,$seal,$seal_size,$thumbnailName,$x,$y);
                    return "ok_sign";
                }
                return "ok";
            }
        }
        return "未登录";
    }

}