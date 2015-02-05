<?php

namespace app\models;

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
 * @property integer $forward_count
 * @property integer $praise_count
 * @property integer $video_state
 */
class Videos extends \yii\db\ActiveRecord
{
    const VIDEO_ACTIVE = 1;
    const VIDEO_DISABLE = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%videos}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'game_id', 'video_title', 'video_date', 'video_path', 'forward_count', 'praise_count', 'video_state'], 'required'],
            [['user_id', 'game_id', 'forward_count', 'praise_count', 'video_state'], 'integer'],
            [['video_date'], 'safe'],
            [['video_title'], 'string', 'max' => 100],
            [['video_path'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'vid' => Yii::t('app', 'Vid'),
            'user_id' => Yii::t('app', 'User ID'),
            'game_id' => Yii::t('app', 'Game ID'),
            'video_title' => Yii::t('app', 'Video Title'),
            'video_date' => Yii::t('app', 'Video Date'),
            'video_path' => Yii::t('app', 'Video Path'),
            'forward_count' => Yii::t('app', 'Forward Count'),
            'praise_count' => Yii::t('app', 'Praise Count'),
            'video_state' => Yii::t('app', 'Video State'),
        ];
    }

    public function getUser()
    {
        return $this->hasOne(Users::className(), ['uid' => 'user_id']);
    }

    public static function oneHourVideo()
    {
        $one_hour_front_timestamp  = time()-3600;
        $one_hour_front = date('Y-m-d H:i:s',$one_hour_front_timestamp);
        //, 'between','video_date', $one_hour_front , date('Y-m-d H:i:s')
        return Videos::find()
            ->joinWith('user')
            ->where(['video_state' => Videos::VIDEO_ACTIVE])
            ->orderBy(['video_date' => SORT_DESC])
            ->all();
    }
}
