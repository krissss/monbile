<?php
use yii\helpers\Url;

/* @var $this \yii\web\View */

$this->title = '个人视频';

$videos = Url::to('/videos/');

if (isset($other_user_info) && $other_user_info) {
    $user_info = $other_user_info;
}
?>
<div class="user-default-index">
    <div class="row">
        <div class="col-xs-12 col-md-8">
            <div class="row">
                <?php if (isset($user_info) && $user_info): ?>
                    <?php if (!is_array($user_info->videos) || count($user_info->videos) < 1): ?>
                        <div class="alert alert-info col-xs-12" role="alert">您还没有发布任何视频</div>
                    <?php else: ?>
                        <?php foreach (array_reverse($user_info->videos) as $video_info): ?>
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
                <?php endif; ?>
            </div>
        </div>
        <div class="col-xs-12 col-md-4">
            <?php require(__DIR__ . '/../../../../views/site/fragment/user_info.php'); ?>
        </div>
    </div>
</div>