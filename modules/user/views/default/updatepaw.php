<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = '修改信息';

$heads = Url::to('/heads/');
?>
<div class="site-login">
    <div class="text-center">
        <a href="<?=Url::to(['/user/default/changehead'])?>"><img src="<?= Url::to($heads . $model->head) ?>" alt="点我修改头像" title="点我修改头像" class="img-circle img-responsiv img_height_150"></a>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <?php $form = ActiveForm::begin([
                'id' => 'updatepaw-form',
                'options' => ['class' => 'form-horizontal'],
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-xs-12 col-md-3\">{input}</div>\n<div class=\"col-xs-12 col-md-4\">{error}</div>",
                    'labelOptions' => ['class' => 'col-xs-12 col-md-5 control-label'],
                ],
            ]); ?>
            <?= $form->field($model, 'password')->passwordInput()->label('新密码') ?>
            <?= $form->field($model, 'password_2')->passwordInput()->label('确认密码') ?>
            <div class="form-group">
                <div class="col-md-offset-5 col-md-7">
                    <?= Html::submitButton('更新', ['class' => 'btn btn-primary', 'name' => 'updatepaw-button']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>