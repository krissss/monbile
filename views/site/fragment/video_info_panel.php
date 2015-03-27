<?php
/**
 * 视频信息2（外链的视频）
 * site/index   user/default/index  user/default/collections
 * 在包含页面需定义以下变量
 */
/* @var $video_info :: foreach*/
/* @var $top_info :: foreach :: 来自榜单*/
/* @var $key :: foreach :: 来自榜单*/
/* @var $collections_array :: render */
/* @var $is_other_user_video :: false or true(其他用户的video) */
/* #commentsModal在comments_modal.php文件中，使用时需被包含一起使用 */

use yii\helpers\Url;
use app\functions\Functions;
use app\models\Users;
use yii\helpers\Html;

$session_user = Yii::$app->getSession()->get('user');
$thumbnail_path = Url::to('./imgs/thumbnail/');
$imgs = Url::to('./imgs/')
?>
<div class="panel panel-default">
    <div class="row">
        <div class="col-xs-12 visible-xs">
            <div class="row">
                <div class="col-xs-3">
                    <a href="<?= Url::to(['/user/default/index', 'id' => $video_info->user->uid]) ?>">
                        <img src="<?= Url::to($heads . $video_info->user->head) ?>" alt="<?= $video_info->user->nickname ?>" title="<?= $video_info->user->nickname ?>" class="img-circle img-responsiv" width="100%">
                    </a>
                </div>
                <div class="col-xs-9">
                    <h5 class="media-heading">
                        <?php if($video_info->user->sex == Users::USER_SEX_MALE):?>
                            <strong class="text-primary"><?= $video_info->user->nickname ?></strong>
                            <div class="self_icon icon_male_circle"></div>
                        <?php elseif($video_info->user->sex == Users::USER_SEX_FEMALE):?>
                            <strong class="text-danger"><?= $video_info->user->nickname ?></strong>
                            <div class="self_icon icon_female_circle"></div>
                        <?php else:?>
                            <strong><?= $video_info->user->nickname ?></strong>
                        <?php endif; ?>
                    </h5>
                    <p class="text-muted"><a href="<?=Url::to(['/site/video','id'=>$video_info->vid])?>"><?= $video_info->video_title ?></a></p>
                    <p class="text-muted text-right">—— <?=Functions::formatTime($video_info->video_date);?></p>
                </div>
            </div>
        </div>
        <div class="col-xs-8 video_user_media hidden-xs">
            <div class="row">
                <div class="col-xs-2">
                    <a href="<?= Url::to(['/user/default/index', 'id' => $video_info->user->uid]) ?>">
                        <img src="<?= Url::to($heads . $video_info->user->head) ?>" alt="<?= $video_info->user->nickname ?>" title="<?= $video_info->user->nickname ?>" class="img-circle img-responsiv" width="100%">
                    </a>
                </div>
                <div class="col-xs-10">
                    <h4 class="media-heading">
                        <?php if($video_info->user->sex == Users::USER_SEX_MALE):?>
                            <strong class="text-primary"><?= $video_info->user->nickname ?></strong>
                            <div class="self_icon icon_male_circle"></div>
                        <?php elseif($video_info->user->sex == Users::USER_SEX_FEMALE):?>
                            <strong class="text-danger"><?= $video_info->user->nickname ?></strong>
                            <div class="self_icon icon_female_circle"></div>
                        <?php else:?>
                            <strong><?= $video_info->user->nickname ?></strong>
                        <?php endif; ?>
                    </h4>
                    <p class="text-white has_face"><a href="<?=Url::to(['/site/video','id'=>$video_info->vid])?>"><?= $video_info->video_title ?></a></p>
                    <p class="text-white text-right">—— <?=Functions::formatTime($video_info->video_date);?></p>
                </div>
            </div>
        </div>
        <a href="<?= $video_info->video_path?>" target="_blank" class="col-xs-4"><img src="<?=Url::to($imgs . 'play.png')?>" class="video_play_button" width="60%"></a>
        <img src="<?= Url::to($thumbnail_path . $video_info->video_thumbnail.'.png') ?>" alt="video_thumbnail" class="col-xs-12 video_thumbnail_bg" height="100%">
    </div>
    <div class="btn-group btn-group-justified" role="group" aria-label="菜单" data-video-id="" data-video-user-id="">
        <a href="javascript:void(0);" class="btn btn-default add_collection" role="button"><span class="glyphicon glyphicon-star <?= in_array($video_info->vid,$collections_array,true)?'glyphicon-inverse':'' ?>" aria-hidden="true"></span><?= in_array($video_info->vid,$collections_array,true)?'已':'' ?>收藏</a>
        <a href="javascript:void(0);" class="btn btn-default show_comments" role="button" data-toggle="modal" data-target="#commentsModal"><span class="glyphicon glyphicon-comment" aria-hidden="true"></span>评论<span class="badge comment_count_<?=$video_info->vid?>"><?= $video_info->comment_count ?></span></a>
        <a href="javascript:void(0);" class="btn btn-default praise" tabindex="0" role="button" data-toggle="popover" title="选择点赞图"><span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>赞<span class="badge praise_count"><?= $video_info->praise_count ?></span></span></a>
    </div>
</div>

<div id="popoverContent" class="hidden">
    <div class="row">
        <?php if($session_user):?>
            <a href="javascript:void(0);"><?=Html::img("./imgs/seal/".$session_user->uid."/seal_1.png",['class'=>'col-xs-6','title'=>'便便'])?></a>
            <a href="javascript:void(0);"><?=Html::img("./imgs/seal/".$session_user->uid."/seal_2.png",['class'=>'col-xs-6','title'=>'火火火'])?></a>
            <a href="javascript:void(0);"><?=Html::img("./imgs/seal/".$session_user->uid."/seal_3.png",['class'=>'col-xs-6','title'=>'水水水'])?></a>
            <a href="javascript:void(0);"><?=Html::img("./imgs/seal/".$session_user->uid."/seal_4.png",['class'=>'col-xs-6','title'=>'王者风范'])?></a>
        <?php else:?>
            <a href="javascript:void(0);"><?=Html::img("./imgs/seal/seal_1.png",['class'=>'col-xs-6','title'=>'便便'])?></a>
            <a href="javascript:void(0);"><?=Html::img("./imgs/seal/seal_2.png",['class'=>'col-xs-6','title'=>'火火火'])?></a>
            <a href="javascript:void(0);"><?=Html::img("./imgs/seal/seal_3.png",['class'=>'col-xs-6','title'=>'水水水'])?></a>
            <a href="javascript:void(0);"><?=Html::img("./imgs/seal/seal_4.png",['class'=>'col-xs-6','title'=>'王者风范'])?></a>
        <?php endif; ?>
    </div>
</div>