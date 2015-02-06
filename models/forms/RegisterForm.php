<?php

namespace app\models\forms;

use app\models\Users;
use Faker\Provider\DateTime;
use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 */
class RegisterForm extends Model
{
    public $nickname;
    public $email;
    public $password;

    public function rules()
    {
        return [
            [['email', 'nickname'], 'required'],
            [['email', 'nickname'], 'filter', 'filter' => 'trim'],
            [['nickname'], 'string','min'=>2, 'max' => 20],
            ['email', 'email'],
            [['email', 'nickname'], 'unique', 'targetClass'=>'app\models\Users',  'message' => '{attribute}"{value}"已被占用。']
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => Yii::t('app', 'Email'),
            'nickname' => Yii::t('app', 'Nickname'),
        ];
    }

    public function sendPassword()
    {
        if ($this->validate()) {
            $this ->password = Users::createRandPassword();
            $mail = Yii::$app->mailer->compose();
            $mail->setTo($this->email);
            $mail->setSubject('monbile用户注册');
            $mail->setHtmlBody('亲爱的"' . $this->nickname . '",您可以使用该邮箱号和密码：' . $this ->password . '进行登录22');
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
        $user->password = Users::password_encrypt($this->password);
        $user->head = Users::createRandHead();
        $user->role_id = Users::ROLE_USER_GENERAL;
        $user->create_date = date('Y-m-d H:i:s');
        $user->update_date = date('Y-m-d H:i:s');
        if($user->save()){
            return $user;
        }
        return null;
    }
}
