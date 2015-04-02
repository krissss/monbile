<?php
namespace app\widgets;

use app\models\Users;
use yii\base\Widget;

class HotUserWidget extends Widget{
    public $users_hot;

    public function init()
    {
        parent::init();
        if ($this->users_hot === null) {
            $this->users_hot = Users::findHotUsers();
        }
    }

    public function run()
    {
        return $this->render('hot_user',[
            'users_hot'=>$this->users_hot
        ]);
    }
}