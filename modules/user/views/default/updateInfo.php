<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

/* @var $this \yii\web\View */

$this->title = '修改信息';

$heads = Url::to('/heads/');

$session = Yii::$app->getSession();
?>
<input class="success_message" type="hidden" value="<?= $session->hasFlash('success_message')?$session->getFlash('success_message'):''?>">
<input class="success_go_url" type="hidden" value="<?= $session->hasFlash('success_go_url')?$session->getFlash('success_go_url'):''?>">

<div class="user-default-updateinfo">
    <div class="text-center">
        <img src="<?= Url::to($heads . $model->head) ?>" alt="点我修改头像" title="点我修改头像" class="img-circle img-responsiv img_height_150">
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <?php $form = ActiveForm::begin([
                'id' => 'update-info-form',
                'options' => ['class' => 'form-horizontal'],
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-xs-12 col-md-3\">{input}</div>\n<div class=\"col-xs-12 col-md-4\">{error}</div>",
                    'labelOptions' => ['class' => 'col-xs-12 col-md-5 control-label'],
                    'inline' => true,
                ],
            ]); ?>
            <?= $form->field($model, 'nickname')->textInput(['maxlength' => 20]) ?>
            <?= $form->field($model, 'telphone')->input('tel') ?>
            <?= $form->field($model, 'sex')->radioList(['1'=>'男','0'=>'女']) ?>
            <?= $form->field($model, 'birthday')->input('date') ?>
            <?= $form->field($model, 'currentplace')->textInput() ?>
            <?/**类型暂时只用英雄联盟,需要选择类型打开以下注释
            <?= $form->field($model, 'love_game_id')->dropDownList(['1'=>'英雄联盟','2'=>'DOTA','3'=>'剑灵'],['prompt'=>'请选择']) ?>
             */?>
            <div class="form-group">
                <div class="col-md-offset-5 col-md-7">
                    <?= Html::submitButton('更新', ['class' => 'btn btn-primary', 'name' => 'update-info-button']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>