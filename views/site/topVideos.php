<?php
/**
 * 榜单
 */
/* @var $this \yii\web\View */
/* @var $tops_info :: render */
/* @var $collections_array :: render */
/* @var $is_other_user_video :: false or true(其他用户的video) */
/* #commentsModal在comments_modal.php文件中，使用时需被包含一起使用 */
/* @var $session_user :: session */

use yii\helpers\Url;

$heads = Url::to('/heads/');
$videos = Url::to('/videos/');

$is_other_user_video = true;

$session = Yii::$app->getSession();
$session_user = $session->get('user');

$this->title = '榜单';
?>
<?php require(__DIR__ . '/fragment/comments_modal.php'); ?>

<div class="user-default-videos">
    <?php if(count($tops_info)>0):?>
        <div class="alert alert-info" role="alert">
            <span><?=date("Y-m-d",strtotime($tops_info[0]->top_date))?></span>
            <span class="pull-right"><a href="<?=Url::to(['/site/top-list'])?>">查看更多榜单</a></span>
        </div>
        <?php foreach ($tops_info as $key=>$top_info): ?>
            <?php $video_info = $top_info->video; ?>
            <?php require(__DIR__ . '/fragment/video_info_panel.php'); ?>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="alert alert-danger" role="alert">没有相关信息，<strong><a href="<?=Url::to(['/site/top-list'])?>">点我返回</a></strong></div>
    <?php endif; ?>
</div>