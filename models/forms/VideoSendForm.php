<?php
namespace app\models\forms;

use app\functions\Functions;
use app\models\TagRelation;
use app\models\Tags;
use app\models\Videos;
use Yii;
use yii\base\Model;


class VideoSendForm extends Model
{
    public $video_title;
    public $video_path;
    public $hero;

    public function rules()
    {
        return [
            [['video_title'], 'required', 'message' => '“视频描述”不能为空'],
            [['video_title'], 'string', 'max' => 100],
            [['video_path'], 'required', 'message' => '请填写视频地址'],
            [['video_path'], 'url', 'defaultScheme' => 'http', 'message' => '“URL”地址不合法'],
            [['hero'], 'required', 'message' => '请选择英雄'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'video_title' => Yii::t('app', 'Video Describe'),
            'video_path' => Yii::t('app', 'Video URL'),
            'hero' => Yii::t('app', 'Hero Chose'),
        ];
    }

    public function videoSave($user_id)
    {
        $thumbnailName = Functions::createRandName();
        if(!self::createThumbnail($thumbnailName)){
            return false;
        }
        $video = new Videos();
        $video->user_id = $user_id;
        $video->video_title = $this->video_title;
        $video->video_date = date('Y-m-d H:i:s');
        $video->video_path = $this->video_path;
        $video->video_thumbnail = $thumbnailName;
        $video->comment_count = 0;
        $video->praise_count = 0;
        $video->video_state = Videos::VIDEO_ACTIVE;
        if (!$video->save()) {
            return false;
        }
        return true;
    }

    private function createThumbnail($thumbnailName){
        if($this->hero){
            Functions::createHeroToBackground($this->hero,$thumbnailName);
            return true;
        }
        return false;
    }
}