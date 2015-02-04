<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%tags}}".
 *
 * @property integer $tid
 * @property string $tag_name
 * @property string $create_date
 * @property integer $tag_count
 */
class Tags extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tags}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tag_name', 'create_date'], 'required'],
            [['create_date'], 'safe'],
            [['tag_count'], 'integer'],
            [['tag_name'], 'string', 'max' => 10]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tid' => Yii::t('app', 'Tid'),
            'tag_name' => Yii::t('app', 'Tag Name'),
            'create_date' => Yii::t('app', 'Create Date'),
            'tag_count' => Yii::t('app', 'Tag Count'),
        ];
    }

    public function isExist($tag_name){
        //Tags::findOne()
    }
}
