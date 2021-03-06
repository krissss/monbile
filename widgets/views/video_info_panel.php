<?php
/* @var $video_info */
/* @var $collections_array */
/* @var $img_path */
/* @var $thumbnail_path */
/* @var $head_path */
/* #commentsModal在comments_modal.php文件中，使用时需被包含一起使用 */

use yii\helpers\Url;
use app\functions\Functions;
use app\models\Users;
?>
<div class="panel panel-default">
    <div class="row">
        <div class="col-xs-12 visible-xs">
            <div class="row">
                <div class="col-xs-3">
                    <a href="<?= Url::to(['/user/default/index', 'id' => $video_info->user->uid]) ?>">
                        <img src="<?= Url::to($head_path . $video_info->user->head) ?>" alt="<?= $video_info->user->nickname ?>" title="<?= $video_info->user->nickname ?>" class="img-circle img-responsiv" width="100%">
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
                        <img src="<?= Url::to($head_path . $video_info->user->head) ?>" alt="<?= $video_info->user->nickname ?>" title="<?= $video_info->user->nickname ?>" class="img-circle img-responsiv" width="100%">
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
        <a href="<?= $video_info->video_path?>" target="_blank" class="col-xs-4"><img src="<?=Url::to($img_path . 'play.png')?>" class="video_play_button" width="60%"></a>
        <img src="<?= Url::to($img_path.'loading.gif')?>" data-src="<?= Url::to($thumbnail_path . $video_info->video_thumbnail.'.png') ?>" alt="video_thumbnail" class="col-xs-12 lazyload video_thumbnail_bg video_<?= $video_info->vid ?>" height="100%">
    </div>
    <div class="btn-group btn-group-justified" role="group" aria-label="菜单" data-video-id="<?=$video_info->vid?>" data-video-user-id="<?=$video_info->user->uid?>">
        <a href="javascript:void(0);" class="btn btn-default add_collection" role="button"><span class="glyphicon glyphicon-star <?= in_array($video_info->vid,$collections_array,true)?'glyphicon-inverse':'' ?>" aria-hidden="true"></span><?= in_array($video_info->vid,$collections_array,true)?'已':'' ?>收藏</a>
        <a href="javascript:void(0);" class="btn btn-default show_comments" role="button" data-toggle="modal" data-target="#commentsModal"><span class="glyphicon glyphicon-comment" aria-hidden="true"></span>评论<span class="badge comment_count_<?=$video_info->vid?>"><?= $video_info->comment_count ?></span></a>
        <a href="javascript:void(0);" class="btn btn-default praise" tabindex="0" role="button" data-toggle="popover" title="选择点赞图" data-video="<?=$video_info->vid?>"><span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>赞<span class="badge praise_count_<?= $video_info->vid ?>"><?= $video_info->praise_count ?></span></span></a>
    </div>
</div>