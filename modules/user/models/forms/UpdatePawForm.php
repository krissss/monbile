<?php

namespace app\modules\user\models\forms;

use Yii;
use yii\base\Model;

class UpdatePawForm extends Model
{
    public $password;
    public $password_2;

    public function rules()
    {
        return [
            [['password', 'password_2'], 'required'],
            [['password', 'password_2'], 'string', 'min'=>5],
            ['password_2', 'compare','compareAttribute'=>'password','message'=>'两次密码输入不一致'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'password_2' => Yii::t('app', 'Password_2'),
            'password' => Yii::t('app', 'Password'),
        ];
    }

}