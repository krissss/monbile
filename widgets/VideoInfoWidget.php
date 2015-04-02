<?php
namespace app\widgets;

use app\models\Collections;
use Yii;
use yii\base\Widget;

class VideoInfoWidget extends Widget{
    public $video_info;
    public $collections_array = array();
    public $img_path = './imgs/';
    public $thumbnail_path = './imgs/thumbnail/';
    public $head_path = './heads/';

    public function init()
    {
        parent::init();
        $session_user = Yii::$app->getSession()->get('user');
        if ($session_user) {//已登录用户
            $this->collections_array = Collections::findAllVideoIdInCollectionsByUserId($session_user->uid);
        }
    }

    public function run()
    {
        return $this->render('video_info_panel',[
            'video_info' => $this->video_info,
            'collections_array' => $this->collections_array,
            'img_path' => $this->img_path,
            'thumbnail_path' => $this->thumbnail_path,
            'head_path' => $this->head_path
        ]);
    }
}