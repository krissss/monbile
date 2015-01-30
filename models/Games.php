<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%games}}".
 *
 * @property integer $gid
 * @property string $game_name_zh
 * @property string $game_name_en
 * @property integer $game_hot
 */
class Games extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%games}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['game_name_zh'], 'required'],
            [['game_hot'], 'integer'],
            [['game_name_zh', 'game_name_en'], 'string', 'max' => 20],
            [['game_name_zh'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'gid' => Yii::t('app', 'Gid'),
            'game_name_zh' => Yii::t('app', 'Game Name Zh'),
            'game_name_en' => Yii::t('app', 'Game Name En'),
            'game_hot' => Yii::t('app', 'Game Hot'),
        ];
    }
}
