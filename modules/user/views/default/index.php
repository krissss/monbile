<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
$this->title = '个人主页';

$imgs = Url::to('/imgs/');
$heads = Url::to('/heads/');
$videos = Url::to('/videos/');

$session = Yii::$app->getSession();
$user = $session->get('user');
?>
<input class="success_message" type="hidden" value="<?= $session->hasFlash('success_message')?$session->getFlash('success_message'):''?>">
<input class="warning_message" type="hidden" value="<?= $user && $user->create_date == $user->update_date?'您的密码未修改#存在不安全因素，也可能给您下次登录带来麻烦，请尽快修改。':''?>">
<input class="warning_go_url" type="hidden" value="<?= Url::to(['/user/default/updatepaw'])?>">


<div class="user-default-index">
    <div class="row">
        <div id="error_message" class="alert alert-danger alert-dismissible display_none" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span
                    class="sr-only">Close</span></button>
        </div>
        <div class="col-xs-12 col-md-8">
            <?php if ($user): ?>
                <?php require(__DIR__ . '/../../../../views/site/fragment/video_send.php'); ?>
            <?php endif; ?>
            <div class="btn-group">
                <button type="button" class="btn btn-default btn-sm">全部</button>
                <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown"
                        aria-expanded="false">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu" role="menu">
                    <li role="presentation"><a role="menuitem" tabindex="-2" href="#">全部</a></li>
                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#">原创</a></li>
                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#">转发</a></li>
                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#">收藏</a></li>
                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#">标签</a></li>
                </ul>

            </div>
            <?php if ($user): ?>
                <Button class="btn btn-default btn-sm pull-right"><a href="#send_video" data-toggle="collapse"
                                                                     aria-expanded="false" aria-controls="send_video"
                                                                     role="tab">我要发视频</a></Button>
            <?php endif; ?>
            <?php if(!is_array($user_info->videos)|| count($user_info->videos)<1):?>
                <div class="alert alert-info" role="alert">您还没有发布任何视频</div>
            <?php else:?>
                <?php foreach (array_reverse($user_info->videos) as $video_info): ?>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="media">
                                <div class="media-left">
                                    <a href="#"><img src="<?= Url::to($heads . $video_info->user->head) ?>"
                                                     alt="..."
                                                     class="img-circle img-responsiv img_height_80"></a>
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading">超级管理员</h4>

                                    <p class="has_face"><?= $video_info->video_title ?></p>

                                    <div class="has_tag">
                                        <?php foreach ($video_info->tagRelations as $tagRelation_info): ?>
                                            <span class="tag tag-color-<?=rand(0,6)?>"><?=$tagRelation_info->tag->tag_name?></span>
                                        <?php endforeach; ?>
                                    </div>
                                    <div class="media">
                                        <div class="media-middle">
                                            <video src="<?= Url::to($videos . $video_info->video_path) ?>"
                                                   controls="controls"
                                                   class="col-xs-12">
                                                <p>您的浏览器不支持html5，请更换浏览器</p>
                                            </video>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <h5 class="col-xs-12">
                                            <small><?=$video_info->video_date; ?></small>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="btn-group btn-group-justified" role="group" aria-label="菜单">
                            <a href="#" class="btn btn-default" role="button"><span
                                    class="glyphicon glyphicon-star"
                                    aria-hidden="true"></span>收藏</a>
                            <a href="#" class="btn btn-default" role="button"><span
                                    class="glyphicon glyphicon-share-alt"
                                    aria-hidden="true"></span>转发<span
                                    class="badge"><?= $video_info->forward_count ?></span></a>
                            <a href="#" class="btn btn-default" role="button"><span
                                    class="glyphicon glyphicon-comment"
                                    aria-hidden="true"></span>评论<span
                                    class="badge"><?= $video_info->forward_count ?></span></a>
                            <a href="#" class="btn btn-default"
                               role="button"><span class="glyphicon glyphicon-thumbs-up"
                                                   aria-hidden="true"></span>赞<span
                                    class="badge"><?= $video_info->praise_count ?></span></a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?endif;?>
        </div>
        <div class="col-xs-12 col-md-4">
           <?php require(__DIR__.'/../../../../views/site/fragment/user_info.php');?>
        </div>
    </div>
</div>
