<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%tops}}".
 *
 * @property integer $tid
 * @property integer $video_id
 * @property integer $top_term
 * @property string $top_date
 * @property integer $top_type
 */
class Tops extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tops}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['video_id', 'top_term', 'top_date', 'top_type'], 'required'],
            [['video_id', 'top_term', 'top_type'], 'integer'],
            [['top_date'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tid' => Yii::t('app', 'Tid'),
            'video_id' => Yii::t('app', 'Video ID'),
            'top_term' => Yii::t('app', 'Top Term'),
            'top_date' => Yii::t('app', 'Top Date'),
            'top_type' => Yii::t('app', 'Top Type'),
        ];
    }
}
