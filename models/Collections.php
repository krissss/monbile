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
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%collections}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'video_id', 'collection_date'], 'required'],
            [['user_id', 'video_id'], 'integer'],
            [['collection_date'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'lid' => Yii::t('app', 'Lid'),
            'user_id' => Yii::t('app', 'User ID'),
            'video_id' => Yii::t('app', 'Video ID'),
            'collection_date' => Yii::t('app', 'Collection Date'),
        ];
    }
}
