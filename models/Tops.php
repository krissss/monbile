<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%tops}}".
 *
 * @property integer $tid
 * @property integer $video_id
 * @property integer $top_praise
 * @property string $top_date
 * @property integer $top_type
 * @property integer $top_state
 */
class Tops extends \yii\db\ActiveRecord
{
    const TOP_TYPE_WEEK = 0;
    const TOP_TYPE_MONTH = 1;
    const TOP_TYPE_YEAR = 2;

    const TOP_STATE_DISABLE = 0;
    const TOP_STATE_ENABLE = 1;
    const TOP_STATE_PASSED = 2;

    public static function tableName()
    {
        return '{{%tops}}';
    }

    public function rules()
    {
        return [
            [['video_id', 'top_praise', 'top_date', 'top_type', 'top_state'], 'required'],
            [['video_id', 'top_praise', 'top_type', 'top_state'], 'integer'],
            [['top_date'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'tid' => Yii::t('app', 'Tid'),
            'video_id' => Yii::t('app', 'Video ID'),
            'top_praise' => Yii::t('app', 'Top Praise'),
            'top_date' => Yii::t('app', 'Top Date'),
            'top_type' => Yii::t('app', 'Top Type'),
            'top_state' => Yii::t('app', 'Top State'),
        ];
    }

    /**
     * 一对一关联，一个top对应一个video
     * @return \yii\db\ActiveQuery
     */
    public function getVideo()
    {
        return $this->hasOne(Videos::className(), ['vid' => 'video_id']);
    }

    /**
     * 定时任务，每周/月/年top50插入到tops表
     * @param $date
     * @param int $limit
     * @return bool
     */
    public static function insertTopVideosToTops($date,$top_type,$limit = 50){
        if($top_type == Tops::TOP_TYPE_WEEK){
            $front_date = date('Y-m-d H:i:s',strtotime($date.'-1 week'));
        }elseif($top_type == Tops::TOP_TYPE_MONTH){
            $front_date = date('Y-m-d H:i:s',strtotime($date.'-1 month'));
        }elseif($top_type == Tops::TOP_TYPE_YEAR){
            $front_date = date('Y-m-d H:i:s',strtotime($date.'-1 year'));
        }else{
            $front_date = $date;
        }
        $top = new Tops();
        $top->top_date = $date;
        $top->top_praise = -1;
        $top->video_id = -1;
        $top->top_type = $top_type;
        $top->top_state = Tops::TOP_STATE_ENABLE;
        if(!$top->save()){
            return false;
        }
        $videos = Videos::find()
            ->where(['video_state' => Videos::VIDEO_ACTIVE])
            ->andWhere(['between','video_date', $front_date , $date])
            ->orderBy(['praise_count' => SORT_DESC])
            ->limit($limit)
            ->all();
        foreach($videos as $video){
            $top = new Tops();
            $top->top_date = $date;
            $top->top_praise = $video->praise_count;
            $top->video_id = $video->vid;
            $top->top_type = $top_type;
            $top->top_state = Tops::TOP_STATE_ENABLE;
            if(!$top->save()){
                return false;
            }
        }
        return true;
    }

    /**
     * 获取$date日期那$top_type(周/月/年)赞数量排名前30的视频,用以管理员审核
     * @param $date
     * @param int $limit
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function findTopVideosForAdmin($date,$top_type,$limit = 30)
    {
        return Tops::find()
            ->where(['top_date' => $date,'top_type'=>$top_type])
            ->andWhere(['>=','top_praise',0])
            ->orderBy(['top_praise' => SORT_DESC])
            ->limit($limit)
            ->all();
    }

    public static function findAllTopTypeDateForAdmin(){
        return Tops::find()
            ->select(['top_date','top_type'])
            ->distinct()
            ->orderBy(['top_type'=>SORT_ASC,'top_date'=>SORT_DESC])
            ->all();
    }

    public static function findAllTopNotPassedForAdmin(){
        $tops = Tops::find()
            ->select(['top_date','top_type'])
            ->where(['top_praise'=>-1,'top_state'=>Tops::TOP_STATE_ENABLE])
            ->all();
        $tops_array = array();
        //拼合top_date和top_type，最终用2015-02-160这种形式判断是否在数组中
        foreach($tops as $top){
            array_push($tops_array,$top->top_date.$top->top_type);
        }
        return $tops_array;
    }

    /**
     * 获取$date日期那$top_type(周/月/年)赞数量排名前10的视频,用以展示给用户看
     * @param $date
     * @param int $limit
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function findTopVideosForUser($date,$top_type,$limit=10)
    {
        $isPassed = Tops::find()
            ->where(['top_date' => $date,'top_state'=>Tops::TOP_STATE_PASSED,'top_type'=>$top_type])
            ->one();
        if($isPassed){
            return Tops::find()
                ->where(['top_date' => $date,'top_state'=>Tops::TOP_STATE_ENABLE,'top_type'=>$top_type])
                ->andWhere(['>=','top_praise',0])
                ->orderBy(['top_praise' => SORT_DESC])
                ->limit($limit)
                ->all();
        }else{
            return Tops::find()
                ->where(['top_date' => date('Y-m-d',strtotime($date.'-1 week')),'top_state'=>Tops::TOP_STATE_ENABLE,'top_type'=>$top_type])
                ->andWhere(['>=','top_praise',0])
                ->orderBy(['top_praise' => SORT_DESC])
                ->limit($limit)
                ->all();
        }
    }
}
