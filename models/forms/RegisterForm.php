<?php

namespace app\models\forms;

use app\models\User;
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
            ['email', 'email'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => Yii::t('app', 'Email'),
            'nickname' => Yii::t('app', 'Nickname'),
        ];
    }

    public function sendPassword($model)
    {
        $password = '123456789';
        $mail = Yii::$app->mailer->compose();
        $mail->setTo($model->email);
        $mail->setSubject('monbile用户注册');
        $mail->setHtmlBody('亲爱的"'.$model->nickname.'",您可以使用该邮箱号和密码：'.$password.'进行登录');
        if ($mail->send()) {
            return true;
        } else {
            return false;
        }
    }
}
