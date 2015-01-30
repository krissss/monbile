<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%roles}}".
 *
 * @property integer $rid
 * @property string $role_name
 * @property string $role_content
 */
class Roles extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%roles}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rid', 'role_name', 'role_content'], 'required'],
            [['rid'], 'integer'],
            [['role_name'], 'string', 'max' => 20],
            [['role_content'], 'string', 'max' => 255],
            [['rid'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'rid' => Yii::t('app', 'Rid'),
            'role_name' => Yii::t('app', 'Role Name'),
            'role_content' => Yii::t('app', 'Role Content'),
        ];
    }
}
