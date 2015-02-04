<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%tag_relation}}".
 *
 * @property integer $tag_id
 * @property integer $video_id
 * @property integer $user_id
 */
class TagRelation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tag_relation}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tag_id', 'video_id', 'user_id'], 'required'],
            [['tag_id', 'video_id', 'user_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tag_id' => Yii::t('app', 'Tag ID'),
            'video_id' => Yii::t('app', 'Video ID'),
            'user_id' => Yii::t('app', 'User ID'),
        ];
    }
}
