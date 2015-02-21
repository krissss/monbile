<?php

namespace app\modules\superAdmin\controllers;

use app\models\Tops;
use app\models\Users;
use Yii;
use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        $user = Yii::$app->getSession()->get('user');
        if($user && Users::isUserSuperAdmin($user)){
            return $this->render('index');
        }
        return $this->goHome();
    }

    public function actionChoseTop(){
        $user = Yii::$app->getSession()->get('user');
        if($user && Users::isUserSuperAdmin($user)){
            return $this->render('choseTop',[
                'videos_info' => Tops::findTopVideosForAdmin(date("Y-m-d",strtotime("-1 week Monday")),Tops::TOP_TYPE_WEEK),
            ]);
        }
        return $this->goHome();
    }

    public function actionPassVideo(){
        $user = Yii::$app->getSession()->get('user');
        if($user && Users::isUserSuperAdmin($user)){
            $top_id = Yii::$app->request->post('top_id');
            $top = Tops::find()->where(['tid'=>$top_id])->one();
            if($top->top_state == Tops::TOP_STATE_ENABLE){//下面改成未通过
                $top->top_state = Tops::TOP_STATE_DISABLE;
                $message = 'ok_pass';
            }else if($top->top_state == Tops::TOP_STATE_DISABLE){//下面改成通过
                $top->top_state = Tops::TOP_STATE_ENABLE;
                $message = 'ok_passed';
            }else{//不存在的状态
                return '非法状态,请联系管理员';
            }
            if(!$top->update()){
                return '保存视频状态时出错';
            };
            return $message;
        }
        return $this->goHome();
    }

    public function actionEndPassVideo(){
        $user = Yii::$app->getSession()->get('user');
        if($user && Users::isUserSuperAdmin($user)){
            $top_type = Yii::$app->request->post('top_type');
            $top_date = Yii::$app->request->post('top_date');
            $top = Tops::find()->where(['top_type'=>$top_type,'top_date'=>$top_date, 'top_praise'=>-1])->one();
            if($top->top_state != Tops::TOP_STATE_PASSED){
                $top->top_state = Tops::TOP_STATE_PASSED;
                if(!$top->update()){
                    return '保存榜单状态时出错，请联系超管';
                };
            }
            return 'ok_passed';
        }
        return $this->goHome();
    }
}
