<?php
/**
 * 个人收藏 or XX的视频
 */
/* @var $this \yii\web\View */
/* @var $collections_array :: render or array()(用户未登录) */
/* @var $is_other_user_video :: true */
/* 若是查看自己的收藏，需以下变量 */
/* @var $user :: session */
/* @var $is_other_user :: false; */
/* 若是查看他人的收藏，需以下变量 */
/* @var $user :: render($other_user) */
/* @var $is_other_user :: true; */

use yii\helpers\Url;

$heads = Url::to('/heads/');
$videos = Url::to('/videos/');

$session = Yii::$app->getSession();
$user = $session->get('user');

if(!isset($collections_array)){
    $collections_array = array();
}

$is_other_user = false;
$is_other_user_video = true;
if(isset($other_user) && $other_user){
    $user = $other_user;
    $is_other_user = true;
}

$this->title = $user->nickname.'的收藏';
?>
<?php require(__DIR__ . '/../../../../views/site/fragment/comments_modal.php'); ?>

<div class="user-default-index">
    <div class="row">
        <div class="col-xs-12 col-md-4 pull-right">
            <?php require(__DIR__ . '/../../../../views/site/fragment/user_info.php'); ?>
        </div>
        <div class="col-xs-12 col-md-8 pull-left">
            <div class="btn-group">
                <button type="button" class="btn btn-default btn-sm">全部</button>
                <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
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
            <?php if (count($user->videos) < 1): ?>
                <div class="alert alert-info" role="alert">还没有发布任何视频</div>
            <?php else: ?>
                <?php foreach ($user->collections as $collection): ?>
                    <?php $video_info = $collection->video; ?>
                    <?php require(__DIR__ . '/../../../../views/site/fragment/video_info_panel.php'); ?>
                <?php endforeach; ?>
            <? endif; ?>
        </div>
    </div>
</div>