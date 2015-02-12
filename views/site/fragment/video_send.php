<?php
/**
 * 发布视频
 * site/index   user/default/index
 * 在包含页面需定义以下变量
 */
/* @var $video_send :: render */
/* @var $games :: render */
/* @var $user :: session */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>
<div class="panel panel-default collapse" id="send_video">
    <div class="panel-body">
        <?php $form = ActiveForm::begin([
            'id' => 'video-send-form',
            'options' => ['enctype' => 'multipart/form-data','class' => 'form-horizontal'],
            'fieldConfig' => [
                'template' => "<div class=\"col-xs-12\">{input}</div>\n{error}",
                'errorOptions' => ['class'=> 'error_hide'],
            ],
        ]); ?>
        <?= $form->field($video_send, 'user_id')->hiddenInput(['value'=>$user->uid]) ?>
        <?= $form->field($video_send, 'tags')->hiddenInput(['id' => 'tags']) ?>
        <?= $form->field($video_send, 'game_id')->hiddenInput(['id'=> 'classify']) ?>
        <?= $form->field($video_send, 'video_title')->textarea(['maxlength'=>100,'rows'=>3]) ?>
        <?= $form->field($video_send, 'video_path')->fileInput(['id'=>'upload_file']) ?>
        <button type="button" class="btn btn-default" id="add_face">添加表情</button>
        <button type="button" class="btn btn-default" id="add_tag">标签</button>
        <div class="dropdown div_inline">
            <button class="btn btn-default dropdown-toggle" type="button" id="change_classify" data-toggle="dropdown" aria-expanded="true">
                类型 <span class="caret"></span>
            </button>
            <ul id="change_classify_ul" class="dropdown-menu" role="menu" aria-labelledby="change_classify">
                <?php foreach ($games as $game):?>
                    <li role="presentation" data-gid="<?=$game->gid?>"><a role="menuitem" tabindex="-1" href="javascript:void(0);"><?=$game->game_name_zh?></a></li>
                <?php endforeach;?>
            </ul>
        </div>
        <?= Html::submitButton('发布', ['class' => 'btn btn-primary pull-right', 'name' => 'video-send-button']) ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>
