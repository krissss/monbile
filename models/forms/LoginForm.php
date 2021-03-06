<?php

namespace app\models\forms;

use app\models\Users;
use Yii;
use yii\base\Model;

class LoginForm extends Model
{
    public $email;
    public $password;

    public $_user = false;

    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            ['email', 'email'],
            ['email', 'validateRole'],
            ['password', 'validatePassword']
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => Yii::t('app', 'Email'),
            'password' => Yii::t('app', 'Password'),
        ];
    }

    public function validateRole($attribute)
    {
        $user = $this->getUser();
        if(!$user){
            $this->addError($attribute, '该用户不存在');
        }elseif(Users::isUserDisable($user)){
            $this->addError($attribute, '该用户已被禁止登录');
        }
    }

    public function validatePassword($attribute)
    {
        $user = $this->getUser();
        if(!$user){
        }elseif($user->password!=md5(md5($this->password))){
            $this->addError($attribute, '密码错误');
        }
    }

    public function login()
    {
        if ($this->validate() && $user = $this->getUser()) {
            return $user;
        } else {
            return false;
        }
    }

    public function getUser()
    {
        new DateSearchForm();
        if ($this->_user === false) {
            $this->_user = Users::findByEmail($this->email);
        }
        return $this->_user;
    }
}
