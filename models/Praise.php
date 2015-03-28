<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%praise}}".
 *
 * @property integer $pid
 * @property integer $video_id
 * @property integer $user_id
 * @property string $praise_date
 */
class Praise extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return '{{%praise}}';
    }

    public function rules()
    {
        return [
            [['video_id', 'user_id', 'praise_date'], 'required'],
            [['video_id', 'user_id'], 'integer'],
            [['praise_date'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'pid' => Yii::t('app', 'Pid'),
            'video_id' => Yii::t('app', 'Video ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'praise_date' => Yii::t('app', 'Praise Date'),
        ];
    }

    /**
     * 保存赞
     * @param $user_id
     * @param $video_id
     * @return bool
     */
    public static function savePraise($user_id,$video_id){
        $video = Videos::findOne($video_id);
        if(!$video){
            return false;
        }
        $praise = new Praise();
        $praise->user_id = $user_id;
        $praise->video_id = $video_id;
        $praise->praise_date = date('Y-m-d H:i:s');
        if(!$praise->save()){
            return false;
        }
        $video->praise_count+=1;
        $video->update();
        return true;
    }

    public static function isPraised($user_id,$video_id){
        $praise = Praise::find()
            ->where(['user_id'=>$user_id,'video_id'=>$video_id])
            ->one();
        if($praise){
            return true;
        }
        return false;
    }
}
