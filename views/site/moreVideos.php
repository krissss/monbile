<?php
/**
 * jquery 加载的更多视频信息
 */
/* @var $is_other_user_video :: true :: 相对video_info_panel.php那块而言,视频不可以删除 */
/* @var $collections_array :: render */
/* @var $videos_info :: render */
/* @var $type :: render */
/* @var $offset :: render */
/* 时间搜索 */
/* @var $date_start :: render */
/* @var $date_end :: render */
/* @var $search_type :: render */
/* 标签云搜索 */
/* @var $tag_id :: render */
/* 标签搜索 */
/* @var $search_content :: render */
/* @var $search_type :: render */

use yii\helpers\Url;

$heads = Url::to('/heads/');
$videos = Url::to('/videos/');

$is_other_user_video = true;

$count_num = count($videos_info);
?>
<?php if ($count_num < 1): ?>
    <div class="alert alert-warning text-center" role="alert">没有了 (⊙o⊙)</div>
<?php else: ?>
    <?php foreach ($videos_info as $video_info): ?>
        <?php if(isset($video_info->video)){ $video_info = $video_info->video; }//标签搜索的结果统一化?>
        <?php if(!isset($video_info->vid)){ continue; }//如果视频已被删除，则跳过?>
        <?php require(__DIR__ . '/fragment/video_info_panel.php'); ?>
    <?php endforeach; ?>
    <div><button class="btn btn-primary btn-group-justified get_more" value="加载更多" data-type="<?=$type?>" data-count-num="<?=$offset+$count_num?>" data-date-start="<?=$date_start?>" data-date-end="<?=$date_end?>" data-search-type="<?=$search_type?>" data-search-content="<?=$search_content?>" data-tag-id="<?=$tag_id?>">加载更多</button></div>
<? endif; ?>