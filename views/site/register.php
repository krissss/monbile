<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
$this->title = '注册';

$imgs = Url::to('/imgs/');
$heads = Url::to('/heads/');
$videos = Url::to('/videos/');
?>
<div class="site-register">
    <div class="text-center">
        <img src="<?= Url::to($imgs . 'logo-img-height-200.png') ?>" alt="" class="img-circle img-responsiv">
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <?php $form = ActiveForm::begin([
                'id' => 'register-form',
                'options' => ['class' => 'form-horizontal'],
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-xs-12 col-md-3\">{input}</div>\n<div class=\"col-xs-12 col-md-4\">{error}</div>",
                    'labelOptions' => ['class' => 'col-xs-12 col-md-5 control-label'],
                ],
            ]); ?>
            <?= $form->field($model, 'email') ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <div class="form-group">
                <div class="col-md-offset-5 col-md-7">
                    <?= Html::submitButton('注册', ['class' => 'btn btn-primary', 'name' => 'register-button']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
