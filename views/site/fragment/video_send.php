<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$imgs = Url::to('/imgs/');
$user = Yii::$app->getSession()->get('user');
?>
<div class="panel panel-default collapse" id="send_video">
    <div class="panel-body">
        <?php $form = ActiveForm::begin([
            'id' => 'video-send-form',
            'action' => ['/site/video-send'],
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
            <button class="btn btn-default dropdown-toggle" type="button" id="change_classify" data-toggle="dropdown"
                    aria-expanded="true">
                类型 <span class="caret"></span>
            </button>
            <ul id="change_classify_ul" class="dropdown-menu" role="menu" aria-labelledby="change_classify">
                <li role="presentation" data-gid="1"><a role="menuitem" tabindex="-1"
                                                        href="javascript:void(0);">英雄联盟</a></li>
                <li role="presentation" data-gid="2"><a role="menuitem" tabindex="-1"
                                                        href="javascript:void(0);">Dota</a></li>
                <li role="presentation" data-gid="3"><a role="menuitem" tabindex="-1"
                                                        href="javascript:void(0);">炉石传说</a></li>
                <li role="presentation" data-gid="4"><a role="menuitem" tabindex="-1" href="javascript:void(0);">剑灵</a>
                </li>
            </ul>
        </div>
        <?= Html::submitButton('发布', ['class' => 'btn btn-primary pull-right', 'name' => 'video-send-button']) ?>
        <?php ActiveForm::end(); ?>
<!--        <form role="form" method="post" action="<?/*= Url::to(['/site/video-send']) */?>">
            <div class="form-group" id="video_send_div">
                <input type="hidden" name="user_id" id="classify">
                <label for="exampleInputPassword1" class="counter_label">说点啥</label>
                <textarea id="video_message" class="form-control" rows="3">[呵呵]三杀 四杀 五杀 还有谁</textarea>
                <input type="hidden" name="tag" id="tag">
                <input type="hidden" name="video_game" id="classify">

                <div class="uploader white">
                    <input type="text" class="filename" readonly/>
                    <input type="button" name="file" class="button" value="选择视频"/>
                    <input type="file" size="30"/>
                </div>
            </div>
            <button type="button" class="btn btn-default" id="add_face">添加表情</button>
            <button type="button" class="btn btn-default" id="add_tag">标签</button>
            <div class="dropdown div_inline">
                <button class="btn btn-default dropdown-toggle" type="button" id="change_classify"
                        data-toggle="dropdown" aria-expanded="true">
                    类型 <span class="caret"></span>
                </button>
                <ul id="change_classify_ul" class="dropdown-menu" role="menu" aria-labelledby="change_classify">
                    <li role="presentation" data-gid="1"><a role="menuitem" tabindex="-1" href="javascript:void(0);">英雄联盟</a>
                    </li>
                    <li role="presentation" data-gid="2"><a role="menuitem" tabindex="-1" href="javascript:void(0);">Dota</a>
                    </li>
                    <li role="presentation" data-gid="3"><a role="menuitem" tabindex="-1" href="javascript:void(0);">炉石传说</a>
                    </li>
                    <li role="presentation" data-gid="4"><a role="menuitem" tabindex="-1"
                                                            href="javascript:void(0);">剑灵</a></li>
                </ul>
            </div>
                        <button type="button" class="btn btn-default" id="add_video">添加视频</button>
            <button type="submit" class="btn btn-default pull-right" id="show_face">发布</button>
        </form>-->
    </div>
</div>
