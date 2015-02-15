<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%collections}}".
 *
 * @property integer $lid
 * @property integer $user_id
 * @property integer $video_id
 * @property string $collection_date
 */
class Collections extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return '{{%collections}}';
    }

    public function rules()
    {
        return [
            [['user_id', 'video_id', 'collection_date'], 'required'],
            [['user_id', 'video_id'], 'integer'],
            [['collection_date'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'lid' => Yii::t('app', 'Lid'),
            'user_id' => Yii::t('app', 'User ID'),
            'video_id' => Yii::t('app', 'Video ID'),
            'collection_date' => Yii::t('app', 'Collection Date'),
        ];
    }

    /**
     * 一对一关联，一个collection只有一个user
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['uid' => 'user_id'])
            ->inverseOf('collections');
    }

    /**
     * 一对一关联，一个collection只有一个video
     * @return \yii\db\ActiveQuery
     */
    public function getVideo()
    {
        return $this->hasOne(Videos::className(), ['vid' => 'video_id']);
            //->inverseOf('collections');
    }

    /**
     * 判断某个收藏是否存在
     * @param $user_id
     * @param $video_id
     * @return array|null|\yii\db\ActiveRecord
     */
    public static function isExist($user_id, $video_id){
        return Collections::find()
            ->where(['user_id'=>$user_id, 'video_id'=>$video_id])
            ->one();
    }

    /**
     * 查询某个用户的所有收藏的视频的video_id，并以数组传出，用以判断用户是否收藏了某个视频
     * @param $user_id
     * @return array
     */
    public static function findAllVideoIdInCollectionsByUserId($user_id){
        $collections = Collections::find()
            ->select('video_id')
            ->where(['user_id'=>$user_id])
            ->all();
        $collections_array = array();
        foreach($collections as $collection){
            array_push($collections_array,$collection->video_id);
        }
        return $collections_array;
    }
}
