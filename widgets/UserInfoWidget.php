<?php
/**
 * Created by PhpStorm.
 * User: kriss
 * Date: 2015/4/1
 * Time: 21:03
 */

namespace app\widgets;

use app\models\Relations;
use app\models\Users;
use Yii;
use yii\base\Widget;

class UserInfoWidget extends Widget{
    public $user_id;
    public $user;
    public $is_other_user = false;
    public $relations_array = array();
    public $head_path = './heads/';
    public $img_path = './imgs/';


    public function init()
    {
        parent::init();
        $session_user = Yii::$app->getSession()->get('user');
        if (($session_user && $this->user_id == $session_user->uid) || ($session_user && $this->user_id == null)) {//已登录用户访问自己
            $this->user = $session_user;
        }elseif($this->user_id && $session_user){//已登录用户访问他人
            $this->user = Users::findOne($this->user_id);
            $this->is_other_user = true;
            $this->relations_array = Relations::findAllBackIdInRelationsByFrontId($session_user->uid);
        }else{//未登录用户访问他人
            $this->user = Users::findOne($this->user_id);
            $this->is_other_user = true;
        }
    }

    public function run()
    {
        return $this->render('user_info',[
            'user' => $this->user,
            'is_other_user' => $this->is_other_user,
            'relations_array' => $this->relations_array,
            'head_path' => $this->head_path,
            'img_path' => $this->img_path
        ]);
    }
}