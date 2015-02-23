<?php
/**
 * 首页
 */
/* @var $this \yii\web\View */
/* @var $videos_one_hour :: render */
/* @var $videos_one_day :: render */
/* @var $tags_hot :: session */
/* @var $users_hot :: session */
/* @var $one_week_top :: render */
/* @var $one_month_top :: render */
/* @var $one_year_top :: render */
/* @var $is_other_user :: false :: 相对user_info.php那块而言 */
/* @var $is_other_user_video :: true :: 相对video_info_panel.php那块而言,视频不可以删除 */
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
$session_user = $session->get('user');
$user = $session_user;
$games = $session->get('games');
$tags_hot = $session->get('tags_hot');
$users_hot = $session->get('users_hot');

$is_other_user = false;
$is_other_user_video = true;
?>
<input class="success_message" type="hidden" value="<?= $session->hasFlash('success_message') ? $session->getFlash('success_message') : '' ?>">
<?php require(__DIR__ . '/fragment/comments_modal.php'); ?>

<div class="site-index">
    <div class="row">
        <div id="error_message" class="alert alert-danger alert-dismissible display_none" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        </div>
        <div class="col-xs-12 col-md-8">
            <?php if ($session_user): ?>
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
                    <li role="presentation"><a href="#one_year" aria-controls="one_year" role="tab" data-toggle="tab">年榜</a></li>
                    <?php if ($session_user): ?>
                        <li role="presentation" class="pull-right"><a href="#send_video" data-toggle="collapse" aria-expanded="false" aria-controls="send_video" role="tab">我要“发”视频</a></li>
                    <?php endif; ?>
                    <li role="presentation" class="pull-right"><a href="#search_video" data-toggle="collapse" aria-expanded="false" aria-controls="search_video" role="tab">我要“搜”视频</a></li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade in active" id="one_hour">
                        <?php if (count($videos_one_hour) < 1): ?>
                            <div class="alert alert-warning" role="alert">该时段没有动态</div>
                        <?php else: ?>
                            <?php foreach ($videos_one_hour as $video_info): ?>
                                <?php require(__DIR__ . '/fragment/video_info_panel.php'); ?>
                            <?php endforeach; ?>
                            <div><button class="btn btn-primary btn-group-justified get_more" value="加载更多" data-type="one_hour" data-count-num="<?=count($videos_one_hour)?>">加载更多</button></div>
                        <? endif; ?>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="one_day">
                        <?php if (count($videos_one_day) < 1): ?>
                            <div class="alert alert-warning" role="alert">该时段没有动态</div>
                        <?php else: ?>
                            <?php foreach ($videos_one_day as $video_info): ?>
                                <?php require(__DIR__ . '/fragment/video_info_panel.php'); ?>
                            <?php endforeach; ?>
                            <div><button class="btn btn-primary btn-group-justified get_more" value="加载更多" data-type="one_day" data-count-num="<?=count($videos_one_day)?>">加载更多</button></div>
                        <? endif; ?>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="one_week">
                        <?php if (count($one_week_top) < 1): ?>
                            <div class="alert alert-warning" role="alert">榜单尚未公布,敬请期待</div>
                        <?php else: ?>
                            <div class="alert alert-info" role="alert">
                                <span><?=date("Y-m-d",strtotime($one_week_top[0]->top_date))?>日期</span>
                                <span class="pull-right"><a href="<?=Url::to(['/site/top-list'])?>">查看更多榜单</a></span>
                            </div>
                            <?php foreach ($one_week_top as $key=>$top_info): ?>
                                <?php $video_info = $top_info->video; ?>
                                <?php require(__DIR__ . '/fragment/video_info_panel.php'); ?>
                            <?php endforeach; ?>
                        <? endif; ?>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="one_month">
                        <?php if (count($one_month_top) < 1): ?>
                            <div class="alert alert-warning" role="alert">榜单尚未公布,敬请期待</div>
                        <?php else: ?>
                            <div class="alert alert-info" role="alert">
                                <span><?=date("Y-m",strtotime($one_month_top[0]->top_date))?>月期</span>
                                <span class="pull-right"><a href="<?=Url::to(['/site/top-list'])?>">查看更多榜单</a></span>
                            </div>
                            <?php foreach ($one_month_top as $key=>$top_info): ?>
                                <?php $video_info = $top_info->video; ?>
                                <?php require(__DIR__ . '/fragment/video_info_panel.php'); ?>
                            <?php endforeach; ?>
                        <? endif; ?>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="one_year">
                        <?php if (count($one_year_top) < 1): ?>
                            <div class="alert alert-warning" role="alert">榜单尚未公布,敬请期待</div>
                        <?php else: ?>
                            <div class="alert alert-info" role="alert">
                                <span><?=date("Y",strtotime($one_year_top[0]->top_date))?>年期</span>
                                <span class="pull-right"><a href="<?=Url::to(['/site/top-list'])?>">查看更多榜单</a></span>
                            </div>
                            <?php foreach ($one_year_top as $key=>$top_info): ?>
                                <?php $video_info = $top_info->video; ?>
                                <?php require(__DIR__ . '/fragment/video_info_panel.php'); ?>
                            <?php endforeach; ?>
                        <? endif; ?>
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