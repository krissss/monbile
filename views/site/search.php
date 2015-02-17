<?php
/**
 * 搜索结果页
 */
/* @var $this \yii\web\View */
/* @var $tags_hot :: session */
/* @var $is_other_user :: false; */
/* @var $is_other_user_video :: true; */
/* @var $videos_info :: render */
/* 若用户已经登录，还需以下变量 */
/* @var $user :: session */
/* @var $session_user :: session */

use yii\helpers\Url;

$this->title = '搜索结果';

$heads = Url::to('/heads/');
$videos = Url::to('/videos/');

$session = Yii::$app->getSession();
$user = $session->get('user');
$session_user = $user;
$tags_hot = $session->get('tags_hot');

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
        <div class="col-xs-12 col-md-8">
            <?php if (count($videos_info) < 1): ?>
                <div class="alert alert-info" role="alert">无该标签的信息</div>
            <?php else: ?>
                <div class="alert alert-info" role="alert">搜索结果：</div>
                <?php foreach ($videos_info as $tag_relation): ?>
                    <?php $video_info = $tag_relation->video?>
                    <?php require(__DIR__ . '/fragment/video_info_panel.php'); ?>
                <?php endforeach; ?>
            <? endif; ?>
        </div>
        <div class="col-xs-12 col-md-4 hidden-sm hidden-xs">
            <?php if ($user): ?>
                <?php require(__DIR__ . '/fragment/user_info.php'); ?>
            <?php endif; ?>
            <?php require(__DIR__ . '/fragment/hot_tag.php'); ?>
        </div>
    </div>
</div>