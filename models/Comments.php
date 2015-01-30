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
 */
class Comments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%comments}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['video_id', 'user_id', 'comment_content', 'comment_date', 'comment_state'], 'required'],
            [['video_id', 'user_id', 'comment_state'], 'integer'],
            [['comment_date'], 'safe'],
            [['comment_content'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cid' => Yii::t('app', 'Cid'),
            'video_id' => Yii::t('app', 'Video ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'comment_content' => Yii::t('app', 'Comment Content'),
            'comment_date' => Yii::t('app', 'Comment Date'),
            'comment_state' => Yii::t('app', 'Comment State'),
        ];
    }
}
