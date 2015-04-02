<?php
/**
 * 个人视频 or XX的视频
 */
/* @var $this \yii\web\View */
/* @var $relations_array :: render */
/* 若是查看自己的视频，需以下变量 */
/* @var $user :: session */
/* @var $is_other_user :: false :: 相对user_info.php那块而言 */
/* 若是查看他人视频，需以下变量 */
/* @var $user :: render($other_user) */
/* @var $is_other_user :: true :: 相对user_info.php那块而言 */

use yii\helpers\Url;

$heads = Url::to('/heads/');
$videos = Url::to('/videos/');
$imgs = Url::to('/imgs/');
$thumbnail_path = Url::to('./imgs/thumbnail/');

$session = Yii::$app->getSession();
$user = $session->get('user');

$is_other_user = false;
if(isset($other_user)&&$other_user){
    $user = $other_user;
    $is_other_user = true;
}

$this->title = $user->nickname.'的视频';
?>
<div class="user-default-videos">
    <div class="row">
        <div class="col-xs-12 col-md-8">
            <?php if (count($user->videos) < 1): ?>
                <div class="alert alert-info col-xs-12" role="alert">还没有发布任何视频</div>
            <?php else: ?>
                <?php foreach ($user->videos as $video_info): ?>
                    <div class="col-xs-12 col-md-6">
                        <a href="<?= $video_info->video_path?>" target="_blank" class="col-xs-4"><img src="<?=Url::to($imgs . 'play.png')?>" class="video_play_button" width="60%"></a>
                        <img src="<?= Url::to($imgs.'loading.gif')?>" data-src="<?= Url::to($thumbnail_path . $video_info->video_thumbnail.'.png') ?>" alt="video_thumbnail" class="lazyload video_thumbnail_bg video_<?= $video_info->vid ?>" width="100%" height="100%">
                        <h5><small><?= $video_info->video_date; ?></small></h5>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div class="col-xs-12 col-md-4 hidden-xs hidden-sm">
            <?php require(__DIR__ . '/../../../../views/site/fragment/user_info.php'); ?>
        </div>
    </div>
</div>