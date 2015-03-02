<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%comments}}".
 *
 * @property integer $cid
 * @property integer $video_id
 * @property integer $user_id
 * @property string $comment_content
 * @property string $comment_date
 * @property integer $comment_state
 * @property integer $parent_id
 */
class Comments extends \yii\db\ActiveRecord
{
    const COMMENT_ENABLE = 1;

    public static function tableName()
    {
        return '{{%comments}}';
    }

    public function rules()
    {
        return [
            [['video_id', 'user_id', 'comment_content', 'comment_date', 'comment_state', 'parent_id'], 'required'],
            [['video_id', 'user_id', 'comment_state', 'parent_id'], 'integer'],
            [['comment_date'], 'safe'],
            [['comment_content'], 'string', 'max' => 30]
        ];
    }

    public function attributeLabels()
    {
        return [
            'cid' => Yii::t('app', 'Cid'),
            'video_id' => Yii::t('app', 'Video ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'comment_content' => Yii::t('app', 'Comment Content'),
            'comment_date' => Yii::t('app', 'Comment Date'),
            'comment_state' => Yii::t('app', 'Comment State'),
            'parent_id' => Yii::t('app', 'Parent Id'),
        ];
    }

    /**
     * 一对一关联，一个comment只有一个user
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['uid' => 'user_id']);
    }

    public static function findCommentsByVideoId($video_id){
        return Comments::find()
            ->joinWith('user')
            ->where(['video_id' => $video_id])
            ->orderBy(['comment_date' => SORT_DESC])
            ->all();
    }
}
