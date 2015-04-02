<?php
namespace app\widgets;

use app\models\Relations;
use Yii;
use yii\base\Widget;

class UserRelationInfoWidget extends Widget{
    public $user_relation;
    public $relations_array = array();
    public $session_user;
    public $heads = './heads/';
    public $is_hot_user = false;

    public function init()
    {
        parent::init();
        if ($this->session_user === null) {
            $this->session_user = Yii::$app->getSession()->get('user');
        }
        if($this->session_user){
            $this->relations_array = Relations::findAllBackIdInRelationsByFrontId($this->session_user->uid);
        }
    }

    public function run()
    {
        return $this->render('user_relation_info',[
            'user_relation' => $this->user_relation,
            'relations_array' => $this->relations_array,
            'session_user'=>$this->session_user,
            'heads' => $this->heads,
            'is_hot_user' => $this->is_hot_user
        ]);
    }
}