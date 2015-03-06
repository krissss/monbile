<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%message}}".
 *
 * @property integer $mid
 * @property integer $from_user_id
 * @property integer $to_user_id
 * @property string $message_title
 * @property string $message_content
 * @property string $message_date
 * @property integer $message_state
 * @property integer $about_video_id
 * @property integer $about_comment_id
 */
class Message extends \yii\db\ActiveRecord
{
    const ABOUT_VIDEO_NONE = -1;
    const ABOUT_COMMENT_NONE = 0;
    const MESSAGE_STATE_UNREAD = 0;
    const MESSAGE_STATE_READ = 1;

    public static function tableName()
    {
        return '{{%message}}';
    }

    public function rules()
    {
        return [
            [['from_user_id', 'to_user_id', 'message_title', 'message_content', 'message_date', 'message_state', 'about_video_id', 'about_comment_id'], 'required'],
            [['from_user_id', 'to_user_id', 'message_state', 'about_video_id', 'about_comment_id'], 'integer'],
            [['message_date'], 'safe'],
            [['message_title', 'message_content'], 'string', 'max' => 255]
        ];
    }

    public function attributeLabels()
    {
        return [
            'mid' => Yii::t('app', 'Mid'),
            'from_user_id' => Yii::t('app', 'From User ID'),
            'to_user_id' => Yii::t('app', 'To User ID'),
            'message_title' => Yii::t('app', 'Message Title'),
            'message_content' => Yii::t('app', 'Message Content'),
            'message_date' => Yii::t('app', 'Message Date'),
            'message_state' => Yii::t('app', 'Message State'),
            'about_video_id' => Yii::t('app', 'About Video ID'),
            'about_comment_id' => Yii::t('app', 'About Comment ID'),
        ];
    }

    /**
     * 一对一关联，一个message只有一个from_user_id
     * @return \yii\db\ActiveQuery
     */
    public function getFromUser()
    {
        return $this->hasOne(Users::className(), ['uid' => 'from_user_id']);
    }

    /**
     * 一对一关联，一个message只有一个video_id
     * @return \yii\db\ActiveQuery
     */
    public function getAboutVideo()
    {
        return $this->hasOne(Videos::className(), ['vid' => 'about_video_id']);
    }

    /**
     * 一对一关联，一个message只有一个comment_id
     * @return \yii\db\ActiveQuery
     */
    public function getAboutComment()
    {
        return $this->hasOne(Comments::className(), ['cid' => 'about_comment_id']);
    }

    /**
     * 查询已登录用户的未读消息
     * @param $login_user_id
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function findMessageUnRead($login_user_id){
        return Message::find()
            ->where(['to_user_id'=>$login_user_id,'message_state'=>Message::MESSAGE_STATE_UNREAD])
            ->orderBy(['message_date'=>SORT_DESC])
            ->all();
    }

    /**
     * 发送消息
     * @param $from_user_id
     * @param $to_user_id
     * @param $message_title
     * @param $message_content
     * @param int $about_video_id
     * @return bool
     */
    public static function sendMessage($from_user_id, $to_user_id, $message_title, $message_content, $about_video_id=Message::ABOUT_VIDEO_NONE, $about_comment_id=Message::ABOUT_COMMENT_NONE, $message_state=Message::MESSAGE_STATE_UNREAD){
        $message = new Message();
        $message->from_user_id = $from_user_id;
        $message->to_user_id = $to_user_id;
        $message->message_title = $message_title;
        $message->message_content = $message_content;
        $message->about_video_id = $about_video_id;
        $message->about_comment_id = $about_comment_id;
        $message->message_date = date('Y-m-d H:i:s');
        $message->message_state = $message_state;
        if($message->save()){
            return true;
        }
        return false;
    }
}
