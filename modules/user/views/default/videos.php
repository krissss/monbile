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
            <div class="row">
                <?php if (count($user->videos) < 1): ?>
                    <div class="alert alert-info col-xs-12" role="alert">还没有发布任何视频</div>
                <?php else: ?>
                    <?php foreach ($user->videos as $video_info): ?>
                        <div class="col-xs-12 col-md-6">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <!--<video data-src="<?/*= Url::to($videos . $video_info->video_path) */?>" controls="controls" class="col-xs-12 lazyload">
                                        <p>您的浏览器不支持html5，请更换浏览器</p>
                                    </video>-->
                                    <object width="100%" height="200">
                                        <param name="movie" value="flvplayer.swf">
                                        <param name="quality" value="high">
                                        <param name="allowFullScreen" value="true">
                                        <param name="FlashVars" value="vcastr_file=<?= Url::to($videos . $video_info->video_path) ?>&LogoText=www.monbile.cn&BufferTime=3&IsAutoPlay=0">
                                        <embed src="flvplayer.swf" allowfullscreen="true" flashvars="vcastr_file=<?= Url::to($videos . $video_info->video_path) ?>&LogoText=www.monbile.cn&BufferTime=3&IsAutoPlay=0" quality="high" width="100%" height="200"></embed>
                                    </object>
                                    <h5><small><?= $video_info->video_date; ?></small></h5>
                                    <div class="has_tag">
                                        <?php foreach ($video_info->tagRelations as $tagRelation_info): ?>
                                            <span class="tag tag-color-<?= rand(0, 6) ?>"><?= $tagRelation_info->tag->tag_name ?></span>
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