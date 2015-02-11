<?php
/**
 * 视频信息
 * site/index   user/default/index
 * 在包含页面需定义以下变量
 */
/* @var $video_info object */
/* #commentsModal在comments_modal.php文件中，使用时需被包含一起使用 */

use \yii\helpers\Url;
use \app\functions\Functions;

?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="media">
            <div class="media-left">
                <a href="<?= Url::to(['/user/default/index', 'id' => $video_info->user->uid]) ?>">
                    <img src="<?= Url::to($heads . $video_info->user->head) ?>" alt="<?= $video_info->user->nickname ?>" title="<?= $video_info->user->nickname ?>" class="img-circle img-responsiv img_height_80">
                </a>
            </div>
            <div class="media-body">
                <h4 class="media-heading"><?= $video_info->user->nickname ?></h4>
                <p class="has_face"><?= $video_info->video_title ?></p>
                <div class="has_tag">
                    <?php foreach ($video_info->tagRelations as $tagRelation_info): ?>
                        <span class="tag tag-color-<?= rand(0, 6) ?>"><?= $tagRelation_info->tag->tag_name ?></span>
                    <?php endforeach; ?>
                </div>
                <div class="media">
                    <div class="media-middle">
                        <video src="<?= Url::to($videos . $video_info->video_path) ?>" controls="controls" class="col-xs-12">
                            <p>您的浏览器不支持html5，请更换浏览器</p>
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
    <div class="btn-group btn-group-justified" role="group" aria-label="菜单">
        <a href="#" class="btn btn-default" role="button"><span class="glyphicon glyphicon-star" aria-hidden="true"></span>收藏</a>
        <a href="#" class="btn btn-default" role="button"><span class="glyphicon glyphicon-share-alt" aria-hidden="true"></span>转发<span class="badge"><?= $video_info->forward_count ?></span></a>
        <a href="javascript:void(0);" class="btn btn-default" role="button" data-toggle="modal" data-target="#commentsModal"><span class="glyphicon glyphicon-comment" aria-hidden="true"></span>评论<span class="badge"><?= $video_info->forward_count ?></span></a>
        <a href="#" class="btn btn-default" role="button"><span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>赞<span class="badge"><?= $video_info->praise_count ?></span></a>
    </div>
</div>