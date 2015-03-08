<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%schools}}".
 *
 * @property integer $sid
 * @property string $school_name
 */
class Schools extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%schools}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['school_name'], 'required'],
            [['school_name'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sid' => Yii::t('app', 'Sid'),
            'school_name' => Yii::t('app', 'School Name'),
        ];
    }
}
