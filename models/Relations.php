<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%relations}}".
 *
 * @property integer $rid
 * @property integer $front_id
 * @property integer $back_id
 * @property integer $relation_state
 */
class Relations extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%relations}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['front_id', 'back_id', 'relation_state'], 'required'],
            [['front_id', 'back_id', 'relation_state'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'rid' => Yii::t('app', 'Rid'),
            'front_id' => Yii::t('app', 'Front ID'),
            'back_id' => Yii::t('app', 'Back ID'),
            'relation_state' => Yii::t('app', 'Relation State'),
        ];
    }
}
