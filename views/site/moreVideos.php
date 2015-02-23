<?php
/**
 * jquery 加载的更多视频信息
 */
/* @var $is_other_user_video :: true :: 相对video_info_panel.php那块而言,视频不可以删除 */
/* @var $collections_array :: render */
/* @var $videos_info :: render */
/* @var $type :: render */
/* @var $offset :: render */

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
        <?php require(__DIR__ . '/fragment/video_info_panel.php'); ?>
    <?php endforeach; ?>
    <div><button class="btn btn-primary btn-group-justified get_more" value="加载更多" data-type="<?=$type?>" data-count-num="<?=$offset+$count_num?>">加载更多</button></div>
<? endif; ?>