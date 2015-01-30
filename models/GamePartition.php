<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%game_partition}}".
 *
 * @property integer $gpid
 * @property integer $game_id
 * @property string $game_partition
 */
class GamePartition extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%game_partition}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['game_id', 'game_partition'], 'required'],
            [['game_id'], 'integer'],
            [['game_partition'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'gpid' => Yii::t('app', 'Gpid'),
            'game_id' => Yii::t('app', 'Game ID'),
            'game_partition' => Yii::t('app', 'Game Partition'),
        ];
    }
}
