<?php
/**
 * 单个视频的页面
 */
/* @var $this \yii\web\View */
/* @var $video_info :: render*/
/* @var $collections_array :: render */

$this->title = '视频播放';

use yii\helpers\Url;
use app\functions\Functions;
use app\models\Users;

$heads = Url::to('/heads/');
$videos = Url::to('/videos/');

$is_other_user_video = true;

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
                <p class="has_face text-muted"><?= $video_info->video_title ?></p>
                <div class="has_tag">
                    <?php foreach ($video_info->tagRelations as $tagRelation_info): ?>
                        <span class="tag tag-color-<?= rand(0, 6) ?>"><?= $tagRelation_info->tag->tag_name ?></span>
                    <?php endforeach; ?>
                </div>
                <div class="media">
                    <div class="media-middle">
                        <video class="video-js vjs-default-skin" controls preload="none" width="100%" height="400"
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
<div class="comments_list">
    <?php foreach($video_info->comments as $comment):?>
        <?php if(isset($comment->parent_id)&&$comment->parent_id!=0){ continue; }?>
        <div class="comments_item">
            <div class="media">
                <div class="media-left">
                    <a href="#">
                        <img class="media-object img-circle img-responsiv img_height_35" src="heads/<?=$comment->user->head?>" alt="飒沓" title="飒沓">
                    </a>
                </div>
                <div class="media-body">
                    <p><span class="text-danger"><?=$comment->user->nickname?></span> : <?=$comment->comment_content?></p>
                    <h5><small><?=$comment->comment_date?><a class="pull-right" data-toggle="collapse" href="#collapseExample_<?=$comment->cid?>">回复</a></small></h5>
                    <div class="collapse" id="collapseExample_<?=$comment->cid?>">
                        <form class="form form-group">
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">@<?=$comment->user->nickname?></span>
                                <input type="text" class="form-control comment_content" placeholder="30字以内" maxlength="30" data-comment-video-id="<?=$video_info->vid?>" data-comment-to-user-id="<?=$comment->user->uid?>" data-comment-parent-id="<?=$comment->cid?>">
                            <span class="input-group-btn">
                                <button class="btn btn-primary comment_send" type="button">回复</button>
                            </span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="comments_list">
                <?php foreach($comment->children as $comment_child):?>
                    <div class="comments_item_children">
                        <div class="media">
                            <div class="media-left">
                                <a href="#">
                                    <img class="media-object img-circle img-responsiv img_height_35" src="heads/<?=$comment_child->user->head?>">
                                </a>
                            </div>
                            <div class="media-body">
                                <p><span class="text-danger"><?=$comment_child->user->nickname?></span> : <?=$comment_child->comment_content?></p>
                                <h5>
                                    <small><?=$comment_child->comment_date?>
                                        <?php if(count($comment_child->children)>0):?>
                                            <a class="pull-right" data-toggle="collapse" href="#collapseComments_<?=$comment_child->cid?>">查看对话</a>
                                        <?php endif;?>
                                    </small>
                                </h5>
                                <?php if(count($comment_child->children)>0):?>
                                    <?php foreach($comment_child->children as $comment_child_comments):?>
                                        <div class="collapse" id="collapseComments_<?=$comment_child->cid?>">
                                            <div class="media">
                                                <div class="media-left">
                                                    <a href="#">
                                                        <img class="media-object img-circle img-responsiv img_height_35" src="heads/<?=$comment_child_comments->user->head?>" alt="飒沓" title="飒沓">
                                                    </a>
                                                </div>
                                                <div class="media-body">
                                                    <p><span class="text-danger"><?=$comment_child_comments->user->nickname?></span> : <?=$comment_child_comments->comment_content?></p>
                                                    <h5><small><?=$comment_child_comments->comment_date?></small></h5>
                                                </div>
                                            </div>
                                            <?php while(true):?>
                                                <?php if(count($comment_child_comments->children)>0):?>
                                                    <?php foreach(array_reverse($comment_child_comments->children) as $comment_child_comments):?>
                                                        <div class="media media-remove-margin-top">
                                                            <div class="media-left">
                                                                <a href="#">
                                                                    <img class="media-object img-circle img-responsiv img_height_35" src="heads/<?=$comment_child_comments->user->head?>" alt="飒沓" title="飒沓">
                                                                </a>
                                                            </div>
                                                            <div class="media-body">
                                                                <p><span class="text-danger"><?=$comment_child_comments->user->nickname?></span> : <?=$comment_child_comments->comment_content?></p>
                                                                <h5><small><?=$comment_child_comments->comment_date?></small></h5>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                <?php else: break;?>
                                                <?php endif;?>
                                            <?php endwhile;?>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif;?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>