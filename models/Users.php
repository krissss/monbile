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
 * @property string $introduce
 * @property integer $telphone
 * @property integer $sex
 * @property string $birthday
 * @property string $currentplace
 * @property integer $love_game_id
 * @property integer $love_game_partition_id
 * @property integer $school_id
 */
class Users extends \yii\db\ActiveRecord
{
    const USER_SEX_MALE = 1;
    const USER_SEX_FEMALE = 2;

    public static function tableName()
    {
        return '{{%users}}';
    }

    public function rules()
    {
        return [
            [['email', 'password', 'nickname', 'head', 'role_id', 'create_date', 'update_date','school_id'], 'required'],
            [['role_id', 'sex', 'love_game_id', 'love_game_partition_id','school_id'], 'integer'],
            ['telphone', 'string', 'max' => 11],
            ['telphone', 'match', 'pattern' => '^1(3[0-9]|5[0-35-9]|8[025-9])\\d{8}$^'],
            [['create_date', 'update_date', 'birthday'], 'safe'],
            [['nickname'], 'string', 'min' => 2, 'max' => 20],
            [['currentplace','introduce'],'string']
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
            'introduce' => Yii::t('app', 'Introduce'),
            'telphone' => Yii::t('app', 'Telphone'),
            'sex' => Yii::t('app', 'Sex'),
            'birthday' => Yii::t('app', 'Birthday'),
            'currentplace' => Yii::t('app', 'Currentplace'),
            'love_game_id' => Yii::t('app', 'Love Game ID'),
            'love_game_partition_id' => Yii::t('app', 'Love Game Partition ID'),
            'school_id' => Yii::t('app', 'School Id'),
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
     * 判断用户是否被禁止登录
     * @param $user
     * @return bool
     */
    public static function isUserDisable($user){
        if($user->role_id == Roles::ROLE_USER_DISABLE){
            return true;
        }
        return false;
    }

    /**
     * 判断用户是否是超级管理员
     * @param $user
     * @return bool
     */
    public static function isUserSuperAdmin($user){
        if($user->role_id == Roles::ROLE_USER_SUPER_ADMIN){
            return true;
        }
        return false;
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
     * 查询拥有粉丝较多的用户,按从多到少排序返回数组，最后可以使用user[0]['user']获取到user对象
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function findHotUsers()
    {
        $users = Users::find()
            ->joinWith(['relationsBack'])
            ->all();
        $arrays = array();
        foreach($users as $user){
            $array = ([
                'relationsBack' => count($user->relationsBack),
                'user' => $user,
            ]);
            array_push($arrays,$array);
        }
        rsort($arrays);
        return $arrays;
    }

    /**
     * 查询已登录用户的未读信息数量，用在main.php上
     * @param $session_user_id
     * @return array|\yii\db\ActiveRecord[]
     */
    public function findMessagesUnReadCount($session_user_id)
    {
        return Message::find()
            ->where(['to_user_id' => $session_user_id,'message_state'=>Message::MESSAGE_STATE_UNREAD])
            ->all();
    }
}
