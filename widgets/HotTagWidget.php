<?php
namespace app\widgets;

use app\models\Hero;
use Yii;
use yii\base\Widget;

class HotTagWidget extends Widget{
    public $tags_hot;

    public function init()
    {
        parent::init();
        if ($this->tags_hot === null) {
            $this->tags_hot = Hero::findHotHero();
        }
    }

    public function run()
    {
        return $this->render('hot_tag',[
            'tags_hot'=>$this->tags_hot
        ]);
    }

}