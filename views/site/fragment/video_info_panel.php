<?php
/**
 * 视频信息
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

?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="media">
            <div class="media-left">
                <?php if(isset($top_info) && $top_info && $key==0):?>
                    <img src="<?= Url::to($heads . 'top-one.png') ?>" class="position_absolute_40">
                <?php endif; ?>
                <a href="<?= Url::to(['/user/default/index', 'id' => $video_info->user->uid]) ?>">
                    <img src="<?= Url::to($heads . $video_info->user->head) ?>" alt="<?= $video_info->user->nickname ?>" title="<?= $video_info->user->nickname ?>" class="img-circle img-responsiv img_height_80">
                </a>
                <?php if(isset($top_info) && $top_info):?>
                    <h4 class="text-center"><span class="label label-warning"><?= $top_info->top_praise ?>  <span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span></span></h4>
                <?php endif; ?>
            </div>
            <div class="media-body">
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
                    <?php if(!$is_other_user_video):?>
                        <span class="glyphicon glyphicon-remove cursor_pointer pull-right delete_video" aria-hidden="true" title="删除" data-video-id="<?= $video_info->vid ?>"></span>
                    <?php endif; ?>
                    <?php if(isset($top_info) && $top_info):?>
                        <span class="text-danger pull-right"><strong>第<?= $key+1 ?>名</strong></span>
                    <?php endif; ?>
                </h4>
                <p class="has_face text-muted"><a href="<?=Url::to(['/site/video','id'=>$video_info->vid])?>"><?= $video_info->video_title ?></a></p>
                <div class="has_tag">
                    <?php foreach ($video_info->tagRelations as $tagRelation_info): ?>
                        <span class="tag tag-color-<?= rand(0, 6) ?>"><?= $tagRelation_info->tag->tag_name ?></span>
                    <?php endforeach; ?>
                </div>
                <div class="media">
                    <div class="media-middle">
                        <video class="video-js vjs-default-skin" controls preload="none" width="" height="240"
                               poster="<?=Url::to('thumbnail/'.explode('.',$video_info->video_path)[0].'.jpg')?>"
                               data-setup='{}'>
                            <source src="<?= Url::to($videos . $video_info->video_path) ?>" type='video/mp4' />
                            <p class="vjs-no-js">观看本视频需要您开启浏览器javascript，并且需要浏览器支持HTML5</p>
                        </video>
                    </div>
                </div>
                <div class="row">
                    <h5 class="col-xs-12">
                        <small><?=Functions::formatTime($video_info->video_date);?></small>
                    </h5>
                </div>
            </div>
        </div>
    </div>
    <div class="btn-group btn-group-justified" role="group" aria-label="菜单" data-video-id="<?= $video_info->vid ?>" data-video-user-id="<?= $video_info->user->uid ?>">
        <a href="javascript:void(0);" class="btn btn-default add_collection" role="button"><span class="glyphicon glyphicon-star <?= in_array($video_info->vid,$collections_array,true)?'glyphicon-inverse':'' ?>" aria-hidden="true"></span><?= in_array($video_info->vid,$collections_array,true)?'已':'' ?>收藏</a>
        <a href="javascript:void(0);" class="btn btn-default show_comments" role="button" data-toggle="modal" data-target="#commentsModal"><span class="glyphicon glyphicon-comment" aria-hidden="true"></span>评论<span class="badge comment_count_<?=$video_info->vid?>"><?= $video_info->comment_count ?></span></a>
        <a href="javascript:void(0);" class="btn btn-default give_praise" role="button"><span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>赞<span class="badge praise_count"><?= $video_info->praise_count ?></span></a>
    </div>
</div>