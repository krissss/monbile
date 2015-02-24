<?php
/**
 * 搜索结果页
 */
/* @var $this \yii\web\View */
/* @var $tags_hot :: session */
/* @var $is_other_user :: false :: 相对user_info.php那块而言 */
/* @var $is_other_user_video :: true :: 相对video_info_panel.php那块而言 */
/* @var $videos_info :: render */
/* @var $collections_array :: render */
/* 若用户已经登录，还需以下变量 */
/* @var $user :: session */
/* @var $session_user :: session */
/* 时间搜索还需 */
/* @var $date_start :: render */
/* @var $date_end :: render */
/* @var $search_type :: render */
/* 标签搜索还需 */
/* @var $search_content :: render */
/* @var $search_type :: render */


use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = '搜索结果';

$heads = Url::to('/heads/');
$videos = Url::to('/videos/');

$session = Yii::$app->getSession();
$user = $session->get('user');
$session_user = $user;
$tags_hot = $session->get('tags_hot');

$is_other_user = false;
$is_other_user_video = true;
?>
<input class="success_message" type="hidden" value="<?= $session->hasFlash('success_message') ? $session->getFlash('success_message') : '' ?>">
<?php require(__DIR__ . '/fragment/comments_modal.php'); ?>

<div class="site-index">
    <div class="row">
        <div class="col-xs-12 col-md-8">
            <?php if (count($videos_info) < 1): ?>
                <div class="alert alert-info" role="alert">无搜索结果</div>
            <?php else: ?>
                <div class="alert alert-info" role="alert">搜索结果：</div>
                <?php if(isset($videos_info[0]->vid)): //时间搜索的结果?>
                    <?php foreach ($videos_info as $video_info): ?>
                        <?php if(!isset($video_info->vid)){ continue; }//如果视频已被删除，则跳过?>
                        <?php require(__DIR__ . '/fragment/video_info_panel.php'); ?>
                    <?php endforeach; ?>
                    <div><button class="btn btn-primary btn-group-justified get_more" value="加载更多" data-type="search_date" data-count-num="<?=count($videos_info)?>" data-date-start="<?=$date_start?>" data-date-end="<?=$date_end?>" data-search-type="<?=$search_type?>">加载更多</button></div>
                <?php else: //标签搜索的结果?>
                    <?php foreach ($videos_info as $tag_relation): ?>
                        <?php $video_info = $tag_relation->video?>
                        <?php if(!isset($video_info->vid)){ continue; }//如果视频已被删除，则跳过?>
                        <?php require(__DIR__ . '/fragment/video_info_panel.php'); ?>
                    <?php endforeach; ?>
                    <div><button class="btn btn-primary btn-group-justified get_more" value="加载更多" data-type="search_tag" data-count-num="<?=count($videos_info)?>" data-search-content="<?=$search_content?>" data-search-type="<?=$search_type?>">加载更多</button></div>
                <?php endif; ?>
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