<?php

namespace app\models;

use app\models\forms\SearchForm;
use Yii;

/**
 * This is the model class for table "{{%videos}}".
 *
 * @property integer $vid
 * @property integer $user_id
 * @property integer $game_id
 * @property string $video_title
 * @property string $video_date
 * @property string $video_path
 * @property integer $comment_count
 * @property integer $praise_count
 * @property integer $video_state
 */
class Videos extends \yii\db\ActiveRecord
{
    const VIDEO_ACTIVE = 1;
    const VIDEO_DISABLE = 0;

    public static function tableName()
    {
        return '{{%videos}}';
    }

    public function rules()
    {
        return [
            [['user_id', 'game_id', 'video_title', 'video_date', 'video_path', 'comment_count', 'praise_count', 'video_state'], 'required'],
            [['user_id', 'game_id', 'comment_count', 'praise_count', 'video_state'], 'integer'],
            [['video_date'], 'safe'],
            [['video_title'], 'string', 'max' => 100],
            [['video_path'], 'string', 'max' => 255]
        ];
    }

    public function attributeLabels()
    {
        return [
            'vid' => Yii::t('app', 'Vid'),
            'user_id' => Yii::t('app', 'User ID'),
            'game_id' => Yii::t('app', 'Game ID'),
            'video_title' => Yii::t('app', 'Video Title'),
            'video_date' => Yii::t('app', 'Video Date'),
            'video_path' => Yii::t('app', 'Video Path'),
            'comment_count' => Yii::t('app', 'Comment Count'),
            'praise_count' => Yii::t('app', 'Praise Count'),
            'video_state' => Yii::t('app', 'Video State'),
        ];
    }

    /**
     * 一对一关联，一个video只有一个user
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['uid' => 'user_id'])
            ->inverseOf('videos');
    }

    /**
     * 一对多关联，一个video有多个tagRelation
     * @return \yii\db\ActiveQuery
     */
    public function getTagRelations(){
        return $this->hasMany(TagRelation::className(), ['video_id' => 'vid']);
    }

    /**
     * 一对多关联，一个video有多个comments
     * @return \yii\db\ActiveQuery
     */
    public function getComments(){
        return $this->hasMany(Comments::className(), ['video_id' => 'vid']);
    }

    /**
     * 获取一小时前的视频
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function findOneHourVideos()
    {
        //因视频少，先改为一天内和七天内，下同
        //$one_hour_front = date('Y-m-d H:i:s',strtotime('-1 hour'));
        $one_hour_front = date('Y-m-d H:i:s',strtotime('-1 day'));
        return Videos::find()
            ->where(['video_state' => Videos::VIDEO_ACTIVE])
            ->andWhere(['between','video_date', $one_hour_front , date('Y-m-d H:i:s')])
            ->orderBy(['video_date' => SORT_DESC])
            ->all();
    }

    /**
     * 获取一天前的视频，排除一小时前
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function findOneDayVideos()
    {
        //$one_day_front = date('Y-m-d H:i:s',strtotime('-1 day'));
        //$one_hour_front = date('Y-m-d H:i:s',strtotime('-1 hour'));
        $one_day_front = date('Y-m-d H:i:s',strtotime('-7 day'));
        $one_hour_front = date('Y-m-d H:i:s',strtotime('-1 day'));
        return Videos::find()
            ->where(['video_state' => Videos::VIDEO_ACTIVE])
            ->andWhere(['between','video_date', $one_day_front , $one_hour_front])
            ->orderBy(['video_date' => SORT_DESC])
            ->all();
    }

    /**
     * 更新一个视频的评论数
     * @param $video_id
     * @return bool
     * @throws \Exception
     */
    public static function updateCommentCountByVideoId($video_id){
        $video = Videos::findOne($video_id);
        $video->comment_count += 1;
        if($video->update()){
            return true;
        }
        return false;
    }

    /**
     * 更新一个视频的赞数量
     * @param $video_id
     * @return bool
     * @throws \Exception
     */
    public static function updatePraiseCountByVideoId($video_id){
        $video = Videos::findOne($video_id);
        $video->praise_count += 1;
        if($video->update()){
            return true;
        }
        return false;
    }

    /**
     * 根据标签名和用户名搜索，用户用户自己提交搜索表单
     * @param $tag_name
     * @param int $user_id
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function findVideosByTag($tag_name, $user_id=SearchForm::ALL){
        $tag = Tags::find()
            ->where(['tag_name' => $tag_name])
            ->one();
        if(!$tag){
            return array();
        }
        if($user_id==SearchForm::ALL){
            $tag_relation = TagRelation::find()
                ->where(['tag_id'=>$tag->tid])
                ->all();
        }else{
            $tag_relation = TagRelation::find()
                ->where(['tag_id'=>$tag->tid, 'user_id'=>$user_id])
                ->all();
        }
        return $tag_relation;
    }

    /**
     * 根据标签查找$tag_relation，用于点击标签云
     * @param $tag_id
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function findVideosByTagId($tag_id){
        return TagRelation::find()
            ->where(['tag_id' => $tag_id])
            ->all();
    }

}
