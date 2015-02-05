<?php
namespace app\models\forms;

use app\models\TagRelation;
use app\models\Tags;
use app\models\Videos;
use Yii;
use yii\base\Model;


class VideoSendForm extends Model
{
    public $user_id;
    public $game_id;
    public $video_title;
    public $video_path;
    public $tags;

    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['video_title'], 'required', 'message' => '“发布内容”不能为空'],
            [['video_title'], 'string', 'max' => 100],
            [['video_path'], 'required', 'message' => '“视频”没有选择'],
            [['video_path'], 'file', 'extensions' => 'mp4', 'mimeTypes' => 'video/mp4', 'message' => '只能上传MP4类型视频'],
            [['tags'], 'required', 'message' => '“标签”没有选择'],
            [['game_id'], 'required', 'message' => '“游戏类型”没有选择'],
        ];
    }

    public function videoSave()
    {
        $video = new Videos();
        $video->user_id = $this->user_id;
        $video->game_id = $this->game_id;
        $video->video_title = $this->video_title;
        $video->video_date = date('Y-m-d H:i:s');
        $video->video_path = $this->video_path;
        $video->forward_count = 0;
        $video->praise_count = 0;
        $video->video_state = Videos::VIDEO_ACTIVE;
        if (!$video->save()) {
            return false;
        }

        $arr = explode("#", $this->tags);
        for ($index = 0; $index < count($arr) - 1; $index++) {
            if (!$tag = Tags::findOne(['tag_name'=>$arr[$index]])) {
                $tag = new Tags();
                $tag->tag_name = $arr[$index];
                $tag->create_date = date('Y-m-d H:i:s');
                $tag->tag_count = 1;
                if (!$tag->save()) {
                    return false;
                }
            } else {
                $tag->tag_count++;
                if (!$tag->update()) {
                    return false;
                }

            }

            $tag_relation = new TagRelation();
            $tag_relation->tag_id = $tag->tid;
            $tag_relation->user_id = $this->user_id;
            $tag_relation->video_id = $video->vid;
            if (!$tag_relation->save()) {
                return false;
            }

        }
        return true;
    }
}