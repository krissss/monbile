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
    const ROLE_USER_SUPER_ADMIN = 10;

    public static function tableName()
    {
        return '{{%users}}';
    }

    public function rules()
    {
        return [
            [['email', 'password', 'nickname', 'head', 'role_id', 'create_date', 'update_date'], 'required'],
            [['role_id', 'sex', 'love_game_id', 'love_game_partition_id'], 'integer'],
            ['telphone', 'string', 'max' => 11],
            ['telphone', 'match', 'pattern' => '^1(3[0-9]|5[0-35-9]|8[025-9])\\d{8}$^'],
            [['create_date', 'update_date', 'birthday'], 'safe'],
            [['nickname'], 'string', 'min' => 2, 'max' => 20],
            ['currentplace','string']
        ];
    }

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

    /**
     * 一对多关联，一个user有多个video
     * 按时间倒序排序
     * @return \yii\db\ActiveQuery
     */
    public function getVideos()
    {
        return $this->hasMany(Videos::className(), ['user_id' => 'uid'])
            ->orderBy(['video_date'=>SORT_DESC])
            ->inverseOf('user');
    }

    /**
     * 一对多关联，一个user有多个关注对象
     * @return \yii\db\ActiveQuery
     */
    public function getRelationsFront()
    {
        return $this->hasMany(Relations::className(), ['front_id' => 'uid'])
            ->where(['relation_state' => Relations::RELATION_STABLE])
            ->inverseOf('front');
    }

    /**
     * 一对多关联，一个user有多个粉丝
     * @return \yii\db\ActiveQuery
     */
    public function getRelationsBack()
    {
        return $this->hasMany(Relations::className(), ['back_id' => 'uid'])
            ->where(['relation_state' => Relations::RELATION_STABLE])
            ->inverseOf('back');
    }

    /**
     * 一对多关联，一个user有多个collections
     * @return \yii\db\ActiveQuery
     * 倒叙输出
     */
    public function getCollections()
    {
        return $this->hasMany(Collections::className(), ['user_id' => 'uid'])
            ->orderBy(['collection_date'=>SORT_DESC]);
    }

    /**
     * 创建随机头像
     * @return string
     */
    public static function createRandHead()
    {
        return 'head (' . rand(1, 10) . ').jpg';
    }

    /**
     * 创建随机密码，默认9位
     * @return null|string
     */
    public static function createRandPassword($length = 9)
    {
        $str = null;
        $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $max = strlen($strPol) - 1;
        for ($i = 0; $i < $length; $i++) {
            $str .= $strPol[rand(0, $max)];
        }
        return $str;
    }

    /*
     * 加密密码
     */
    public static function password_encrypt($password)
    {
        return md5(md5($password));
    }

    /**
     * 通过邮箱查找用户
     * @param $email
     * @return static
     */
    public static function findByEmail($email)
    {
        $user = Users::findOne([
            'email' => $email,
        ]);
        return $user;
    }

    /**
     * 查询拥有粉丝较多的用户
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function findHotUsers()//TODO
    {
        return Users::find()
            ->joinWith(['relationsBack'])
            ->all();
    }
}
