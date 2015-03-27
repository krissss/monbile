<?php
/**
 * 发布视频(使用网络链接)
 * site/index   user/default/index
 * 在包含页面需定义以下变量
 */
/* @var $video_send :: render */
/* @var $games :: session */
/* @var $session_user :: session */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>
<div class="panel panel-default collapse" id="send_video">
    <div class="panel-body">
        <?php $form = ActiveForm::begin([
            'id' => 'video-send-form',
            'options' => ['class' => 'form-horizontal'],
            'fieldConfig' => [
                'template' => "{label}<div class='col-sm-9'>{input}{error}</div>",
                'labelOptions' =>['class'=>'col-sm-2 control-label']
            ],
        ]); ?>
        <?=$form->field($video_send,'video_title')?>
        <?=$form->field($video_send,'video_path')?>
        <div class="col-md-offset-2">
            <button type="button" class="btn btn-default heroChose" data-toggle="modal" data-target="#heroChose">
                选择英雄
            </button>
            <?= Html::submitButton('发布', ['class' => 'btn btn-primary', 'name' => 'video-send-submit', 'id'=> 'video-send-submit']) ?>
            <?=$form->field($video_send,'hero')->hiddenInput()->label(false)?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<div class="modal fade" id="heroChose" tabindex="-1" role="dialog" aria-labelledby="heroChose" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">英雄选择</h4>
            </div>
            <div class="modal-body">
                <ul class="dowebok">
                    <li><?=Html::radio('hero_radio',false,['data-labelauty'=>'皮城女警 凯瑟琳','value'=>'kaiseling'])?></li>
                    <li><?=Html::radio('hero_radio',false,['data-labelauty'=>'审判天使 凯尔','value'=>'kaier'])?></li>
                    <li><?=Html::radio('hero_radio',false,['data-labelauty'=>'盲僧','value'=>'mangsen'])?></li>
                    <li><?=Html::radio('hero_radio',false,['data-labelauty'=>'死亡歌颂者 凯尔萨斯','value'=>'kaiersasi'])?></li>
                    <li><?=Html::radio('hero_radio',false,['data-labelauty'=>'暴走萝莉 金克丝','value'=>'jinkesi'])?></li>
                    <li><?=Html::radio('hero_radio',false,['data-labelauty'=>'皮城女警 凯瑟琳','value'=>'kaiseling'])?></li>
                    <li><?=Html::radio('hero_radio',false,['data-labelauty'=>'审判天使 凯尔','value'=>'kaier'])?></li>
                    <li><?=Html::radio('hero_radio',false,['data-labelauty'=>'盲僧','value'=>'mangsen'])?></li>
                    <li><?=Html::radio('hero_radio',false,['data-labelauty'=>'死亡歌颂者 凯尔萨斯','value'=>'kaiersasi'])?></li>
                    <li><?=Html::radio('hero_radio',false,['data-labelauty'=>'暴走萝莉 金克丝','value'=>'jinkesi'])?></li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-primary">确定</button>
            </div>
        </div>
    </div>
</div>
