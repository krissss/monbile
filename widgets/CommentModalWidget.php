<?php

namespace app\widgets;

use Yii;
use yii\base\Widget;

class CommentModalWidget extends Widget{
    public $session_user;
    public $head_path = './heads/';

    public function init()
    {
        parent::init();
        if ($this->session_user === null) {
            $this->session_user = Yii::$app->getSession()->get('user');
        }
    }

    public function run()
    {
        return $this->render('comment_modal',[
            'session_user'=>$this->session_user,
            'head_path'=>$this->head_path,
        ]);
    }
}