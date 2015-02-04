<?php
namespace app\models\forms;

use app\models\Tags;
use app\models\Videos;
use Yii;
use yii\base\Model;


class VideoSendForm extends Model
{
    const VIDEO_ACTIVE = 1;
    const VIDEO_DISABLE = 0;

    public $user_id;
    public $game_id;
    public $video_title;
    public $video_path;
    public $tags;

    public $forward_count = 0;
    public $praise_count = 0;
    public $video_state = VideoSendForm::VIDEO_ACTIVE;

    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['video_title'], 'required', 'message' =>'“发布内容”不能为空'],
            [['video_title'], 'string', 'max' => 100],
            [['video_path'], 'required', 'message' =>'“视频”没有选择'],
            [['video_path'], 'file','extensions' => 'mp4','mimeTypes' => 'video/mp4' ,'message' =>'只能上传MP4类型视频'],
            [['tags'], 'required', 'message' =>'“标签”没有选择'],
            [['game_id'], 'required', 'message' =>'“游戏类型”没有选择'],
        ];
    }

    public function videoSave(){
            $video = new Videos();
            $video->user_id = $this->user_id;
            $video->game_id = $this->game_id;
            $video->video_title = $this->video_title;
            $video->video_date = date('Y-m-d H:i:s');
            $video->video_path = $this->video_path;
            $video->forward_count = $this->forward_count;
            $video->praise_count = $this->praise_count;
            $video->video_state = $this->video_state;
            $tag = new Tags();
            $tag->tag_name = $this->user_id;
            $tag->create_date = $this->user_id;
            $tag->tag_name = $this->user_id;
            $video->forward_count = $this->user_id;

        return true;
    }
}