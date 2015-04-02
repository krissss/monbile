<?php

namespace app\widgets;

use Yii;
use yii\base\Widget;

class SealPopoverWidget extends Widget{
    public $session_user;

    public function init()
    {
        parent::init();
        if ($this->session_user === null) {
            $this->session_user = Yii::$app->getSession()->get('user');
        }
    }

    public function run()
    {
        return $this->render('seal_popover',[
            'session_user'=>$this->session_user,
        ]);
    }
}