<?php

namespace app\models\forms;

use app\functions\Functions;
use app\models\Roles;
use app\models\Users;
use Yii;
use yii\base\Model;

class RegisterForm extends Model
{
    public $nickname;
    public $email;
    public $school;
    public $password;
    public $verifyCode;

    public function rules()
    {
        return [
            [['email', 'nickname','school'], 'required'],
            [['email', 'nickname'], 'filter', 'filter' => 'trim'],
            [['nickname'], 'string','min'=>2, 'max' => 20],
            ['email', 'email'],
            [['email', 'nickname'], 'unique', 'targetClass'=>'app\models\Users',  'message' => '{attribute}"{value}"已被占用。'],
            ['verifyCode', 'captcha'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => Yii::t('app', 'Email'),
            'nickname' => Yii::t('app', 'Nickname'),
            'school' => Yii::t('app', 'School'),
            'verifyCode' => Yii::t('app', 'VerifyCode'),
        ];
    }

    public function sendPassword()
    {
        if ($this->validate()) {
            $this ->password = Users::createRandPassword();
            $mail = Yii::$app->mailer->compose();
            $mail->setTo($this->email);
            $mail->setSubject('monbile用户注册');
            $mail->setHtmlBody('亲爱的"' . $this->nickname . '",您现在可以使用该邮箱号和密码:' . $this ->password . '进行登录');
            if ($mail->send()) {
                return true;
            } else {
                return false;
            }
        }
        return false;
    }

    public function register(){
        $user = new Users();
        $user->email = $this->email;
        $user->nickname = $this->nickname;
        $user->school_id = $this->school;
        $user->password = Users::password_encrypt($this->password);
        $user->head = Users::createRandHead();
        $user->role_id = Roles::ROLE_USER_GENERAL;
        $user->create_date = date('Y-m-d H:i:s');
        $user->update_date = date('Y-m-d H:i:s');
        if($user->save()){
            //用户注册时生成印章
            $nickname = $user->nickname;
            $user_id = $user->uid;
            Functions::createSealWithNickName($nickname,$user_id);
            return $user;
        }
        return null;
    }
}
