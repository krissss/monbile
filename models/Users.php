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
    const ROLE_USER_DISABLE = 0;
    const ROLE_USER_GENERAL = 1;
    const ROLE_USER_SUPER_ADMIN =10;

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
            [['email', 'password', 'nickname', 'head', 'role_id', 'create_date', 'update_date'], 'required'],
            [['role_id', 'telphone', 'sex', 'love_game_id', 'love_game_partition_id'], 'integer'],
            [['create_date', 'update_date', 'birthday'], 'safe'],
            [['nickname'], 'string','min'=>2, 'max' => 20],
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

    public static function getRandHead(){
        return 'head ('.rand(1,10).').jpg';
    }

    public static function getRandPassword(){
        $str = null;
        $length = 9;
        $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $max = strlen($strPol)-1;

        for($i=0;$i<$length;$i++){
            $str.=$strPol[rand(0,$max)];
        }

        return $str;
    }

    public static function password_encrypt($password)
    {
        return md5(md5($password));
    }

    public static function findByEmail($email){
        $user = Users::findOne([
            'email' => $email,
        ]);
        return $user;
    }
}
