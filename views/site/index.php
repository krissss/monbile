<?php
/**
 * 首页
 */
/* @var $this \yii\web\View */
/* @var $videos_one_hour :: render */
/* @var $videos_one_day :: render */
/* @var $tags_hot :: session */
/* @var $users_hot :: session */
/* @var $is_other_user :: false; */
/* @var $is_other_user_video :: true; */
/* @var $collections_array :: render */
/* @var $relations_array :: render */
/* 若用户已经登录，还需以下变量 */
/* @var $video_send :: render */
/* @var $games :: session */
/* @var $user :: session */
/* @var $session_user :: session */

use yii\helpers\Url;

$this->title = Yii::t('app', 'monbile');

$heads = Url::to('/heads/');
$videos = Url::to('/videos/');

$session = Yii::$app->getSession();
$user = $session->get('user');
$session_user = $user;
$games = $session->get('games');
$tags_hot = $session->get('tags_hot');
$users_hot = $session->get('users_hot');

$is_other_user = false;
$is_other_user_video = true;
if(!isset($collections_array)){
    $collections_array = array();
}
?>
<input class="success_message" type="hidden" value="<?= $session->hasFlash('success_message') ? $session->getFlash('success_message') : '' ?>">
<?php require(__DIR__ . '/fragment/comments_modal.php'); ?>

<div class="site-index">
    <div class="row">
        <div id="error_message" class="alert alert-danger alert-dismissible display_none" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        </div>
        <div class="col-xs-12 col-md-8">
            <?php if ($user): ?>
                <?php require(__DIR__ . '/fragment/video_send.php'); ?>
            <?php endif; ?>
            <?php require(__DIR__ . '/fragment/video_search.php'); ?>
            <div role="tabpanel">
                <ul class="nav nav-pills" role="tablist">
                    <?php //因视频少，先改为一天内和七天内   原本是‘1小时内’和 ‘24小时内’ ?>
                    <li role="presentation" class="active"><a href="#one_hour" aria-controls="one_hour" role="tab" data-toggle="tab">一天内</a></li>
                    <li role="presentation"><a href="#one_day" aria-controls="one_day" role="tab" data-toggle="tab">七天内</a></li>
                    <li role="presentation"><a href="#one_week" aria-controls="one_week" role="tab" data-toggle="tab">周榜</a></li>
                    <li role="presentation"><a href="#one_month" aria-controls="one_month" role="tab" data-toggle="tab">月榜</a></li>
                    <?php if ($user): ?>
                        <li role="presentation" class="pull-right"><a href="#send_video" data-toggle="collapse" aria-expanded="false" aria-controls="send_video" role="tab">我要“发”视频</a></li>
                    <?php endif; ?>
                    <li role="presentation" class="pull-right"><a href="#search_video" data-toggle="collapse" aria-expanded="false" aria-controls="search_video" role="tab">我要“搜”视频</a></li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade in active" id="one_hour">
                        <?php if (count($videos_one_hour) < 1): ?>
                            <div class="alert alert-info" role="alert">该时段没有动态</div>
                        <?php else: ?>
                            <?php foreach ($videos_one_hour as $video_info): ?>
                                <?php require(__DIR__ . '/fragment/video_info_panel.php'); ?>
                            <?php endforeach; ?>
                            <!--<button class="btn btn-primary btn-group-justified" value="加载更多">加载更多</button>-->
                        <? endif; ?>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="one_day">
                        <?php if (count($videos_one_day) < 1): ?>
                            <div class="alert alert-info" role="alert">该时段没有动态</div>
                        <?php else: ?>
                            <?php foreach ($videos_one_day as $video_info): ?>
                                <?php require(__DIR__ . '/fragment/video_info_panel.php'); ?>
                            <?php endforeach; ?>
                        <? endif; ?>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="one_week">

                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="one_month">

                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-4 hidden-sm hidden-xs">
            <?php if ($user): ?>
                <?php require(__DIR__ . '/fragment/user_info.php'); ?>
            <?php endif; ?>
            <?php require(__DIR__ . '/fragment/hot_tag.php'); ?>
            <?php require(__DIR__ . '/fragment/hot_user.php'); ?>
        </div>
    </div>
</div>