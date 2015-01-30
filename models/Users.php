<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%users}}".
 *
 * @property integer $uid
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $nickname
 * @property string $head
 * @property integer $role_id
 * @property string $create_date
 * @property string $update_date
 * @property integer $telphone
 * @property integer $sex
 * @property string $birthday
 * @property string $currentplace
 * @property integer $love_game_id
 * @property integer $love_game_partition_id
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%users}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email', 'password', 'nickname', 'head', 'role_id', 'create_date', 'update_date'], 'required'],
            [['role_id', 'telphone', 'sex', 'love_game_id', 'love_game_partition_id'], 'integer'],
            [['create_date', 'update_date', 'birthday'], 'safe'],
            [['username', 'nickname'], 'string', 'max' => 20],
            [['email'], 'string', 'max' => 30],
            [['password'], 'string', 'max' => 50],
            [['head', 'currentplace'], 'string', 'max' => 100],
            [['username', 'email', 'nickname', 'telphone'], 'unique', 'targetAttribute' => ['username', 'email', 'nickname', 'telphone'], 'message' => 'The combination of Username, Email, Nickname and Telphone has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'uid' => Yii::t('app', 'Uid'),
            'username' => Yii::t('app', 'Username'),
            'email' => Yii::t('app', 'Email'),
            'password' => Yii::t('app', 'Password'),
            'nickname' => Yii::t('app', 'Nickname'),
            'head' => Yii::t('app', 'Head'),
            'role_id' => Yii::t('app', 'Role ID'),
            'create_date' => Yii::t('app', 'Create Date'),
            'update_date' => Yii::t('app', 'Update Date'),
            'telphone' => Yii::t('app', 'Telphone'),
            'sex' => Yii::t('app', 'Sex'),
            'birthday' => Yii::t('app', 'Birthday'),
            'currentplace' => Yii::t('app', 'Currentplace'),
            'love_game_id' => Yii::t('app', 'Love Game ID'),
            'love_game_partition_id' => Yii::t('app', 'Love Game Partition ID'),
        ];
    }
}
