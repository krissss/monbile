<?php

namespace app\models;

use app\models\forms\DateSearchForm;
use app\models\forms\SearchForm;
use app\models\forms\TagSearchForm;
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
     * @param int $offset
     * @param int $limit
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function findOneHourVideos($offset = 0, $limit = 10)
    {
        //因视频少，先改为一天内和七天内，下同
        //$one_hour_front = date('Y-m-d H:i:s',strtotime('-1 hour'));
        $one_hour_front = date('Y-m-d H:i:s',strtotime('-1 day'));
        return Videos::find()
            ->where(['video_state' => Videos::VIDEO_ACTIVE])
            ->andWhere(['between','video_date', $one_hour_front , date('Y-m-d H:i:s')])
            ->orderBy(['video_date' => SORT_DESC])
            ->offset($offset)
            ->limit($limit)
            ->all();
    }

    /**
     * 获取一天前的视频，排除一小时前
     * @param int $offset
     * @param int $limit
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function findOneDayVideos($offset = 0, $limit = 10)
    {
        //$one_day_front = date('Y-m-d H:i:s',strtotime('-1 day'));
        //$one_hour_front = date('Y-m-d H:i:s',strtotime('-1 hour'));
        $one_day_front = date('Y-m-d H:i:s',strtotime('-7 day'));
        $one_hour_front = date('Y-m-d H:i:s',strtotime('-1 day'));
        return Videos::find()
            ->where(['video_state' => Videos::VIDEO_ACTIVE])
            ->andWhere(['between','video_date', $one_day_front , $one_hour_front])
            ->orderBy(['video_date' => SORT_DESC])
            ->offset($offset)
            ->limit($limit)
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
     * 根据标签名和用户名搜索，用户自己提交搜索表单
     * @param $tag_name
     * @param int $user_id
     * @param int $offset
     * @param int $limit
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function findVideosByTag($tag_name, $user_id=TagSearchForm::ALL, $offset=0, $limit=10){
        $tags = Tags::find()
            ->where(['or like','tag_name', $tag_name])
            ->all();
        if(!$tags){
            return array();
        }
        $tags_array = array();
        foreach($tags as $tag){
            array_push($tags_array,$tag->tid);
        }
        if($user_id==TagSearchForm::ALL){
            $tag_relation = TagRelation::find()
                ->where(['in','tag_id',$tags_array])
                ->offset($offset)
                ->limit($limit)
                ->orderBy(['video_id'=>SORT_DESC])
                ->all();
        }else{
            $tag_relation = TagRelation::find()
                ->where(['user_id'=>$user_id])
                ->andWhere(['in','tag_id',$tags_array])
                ->offset($offset)
                ->limit($limit)
                ->orderBy(['video_id'=>SORT_DESC])
                ->all();
        }
        return $tag_relation;
    }

    /**
     * 根据时间和用户名搜索，用户自己提交搜索表单
     * @param $video_date_start
     * @param $video_date_end
     * @param int $user_id
     * @param int $offset
     * @param int $limit
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function findVideosByDate($video_date_start, $video_date_end, $user_id=DateSearchForm::ALL, $offset=0, $limit=10){
        if($video_date_start && $video_date_end){
            $video_date_start = date('Y-m-d 00:00:00',strtotime($video_date_start));
            $video_date_end = date('Y-m-d 23:59:59',strtotime($video_date_end));
            if($user_id==DateSearchForm::ALL){
                $videos = Videos::find()
                    ->where(['between','video_date', $video_date_start, $video_date_end])
                    ->offset($offset)
                    ->limit($limit)
                    ->orderBy(['vid' => SORT_DESC])
                    ->all();
            }else{
                $videos = Videos::find()
                    ->where(['user_id'=>$user_id])
                    ->andWhere(['between','video_date', $video_date_start, $video_date_end])
                    ->offset($offset)
                    ->limit($limit)
                    ->orderBy(['vid' => SORT_DESC])
                    ->all();
            }
            return $videos;
        }else{
            return array();
        }
    }

    /**
     * 根据标签查找$tag_relation，用于点击标签云
     * @param $tag_id
     * @param int $offset
     * @param int $limit
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function findVideosByTagId($tag_id, $offset=0, $limit=10){
        return TagRelation::find()
            ->where(['tag_id' => $tag_id])
            ->offset($offset)
            ->limit($limit)
            ->orderBy(['video_id'=>SORT_DESC])
            ->all();
    }

}
