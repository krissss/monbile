<?php
/**
 * 个人视频 or XX的视频
 */
/* @var $this \yii\web\View */
/* 若是查看自己的视频，需以下变量 */
/* @var $user :: session */
/* @var $is_other_user :: false; */
/* 若是查看他人视频，需以下变量 */
/* @var $user :: render($other_user) */
/* @var $is_other_user :: true; */

use yii\helpers\Url;

$videos = Url::to('/videos/');
$heads = Url::to('/heads/');

$session = Yii::$app->getSession();
$user = $session->get('user');

$is_other_user = false;
if(isset($other_user)&&$other_user){
    $user = $other_user;
    $is_other_user = true;
}

$this->title = $user->nickname.'的视频';
?>
<div class="user-default-index">
    <div class="row">
        <div class="col-xs-12 col-md-8">
            <div class="row">
                <?php if (!is_array($user->videos) || count($user->videos) < 1): ?>
                    <div class="alert alert-info col-xs-12" role="alert">您还没有发布任何视频</div>
                <?php else: ?>
                    <?php foreach (array_reverse($user->videos) as $video_info): ?>
                        <div class="col-xs-12 col-md-6">
                            <div class="thumbnail">
                                <video src="<?= Url::to($videos . $video_info->video_path) ?>" controls="controls"
                                       class="col-xs-12">
                                    <p>您的浏览器不支持html5，请更换浏览器</p>
                                </video>
                                <div class="caption">
                                    <h5 class="col-xs-12">
                                        <small><?= $video_info->video_date; ?></small>
                                    </h5>
                                    <div class="has_tag">
                                        <?php foreach ($video_info->tagRelations as $tagRelation_info): ?>
                                            <span
                                                class="tag tag-color-<?= rand(0, 6) ?>"><?= $tagRelation_info->tag->tag_name ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-xs-12 col-md-4">
            <?php require(__DIR__ . '/../../../../views/site/fragment/user_info.php'); ?>
        </div>
    </div>
</div>