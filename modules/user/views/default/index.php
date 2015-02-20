<?php
/**
 * 个人主页 or XX的主页
 */
/* @var $this \yii\web\View */
/* @var $collections_array :: render */
/* @var $relations_array :: render */
/* @var $session_user :: session */
/* 若是查看自己的主页，需以下变量 */
/* @var $user :: session */
/* @var $video_send :: render */
/* @var $games :: session */
/* @var $is_other_user :: false :: 相对user_info.php那块而言 */
/* @var $is_other_user_video :: false :: 相对video_info_panel.php那块而言,视频可以删除 */
/* 若是查看他人主页，需以下变量 */
/* @var $user :: render($other_user) */
/* @var $is_other_user :: true :: 相对user_info.php那块而言 */
/* @var $is_other_user_video :: true :: 相对video_info_panel.php那块而言,视频不可以删除 */

use yii\helpers\Url;

$heads = Url::to('/heads/');
$videos = Url::to('/videos/');

$session = Yii::$app->getSession();
$session_user = $session->get('user');
$user = $session_user;
$games = $session->get('games');

$is_other_user = false;
$is_other_user_video = false;
if(isset($other_user) && $other_user){
    $user = $other_user;
    $is_other_user = true;
    $is_other_user_video = true;
}

$this->title = $user->nickname.'的主页';
?>
<input class="success_message" type="hidden" value="<?= $session->hasFlash('success_message') ? $session->getFlash('success_message') : '' ?>">
<input class="warning_message" type="hidden" value="<?= !$is_other_user && $user->create_date == $user->update_date ? '您的密码未修改#存在不安全因素，也可能给您下次登录带来麻烦，请尽快修改。' : '' ?>">
<input class="warning_go_url" type="hidden" value="<?= Url::to(['/user/default/update-paw']) ?>">
<?php require(__DIR__ . '/../../../../views/site/fragment/comments_modal.php'); ?>

<div class="user-default-index">
    <div class="row">
        <div id="error_message" class="alert alert-danger alert-dismissible display_none" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        </div>
        <div class="col-xs-12 col-md-4 pull-right">
            <?php require(__DIR__ . '/../../../../views/site/fragment/user_info.php'); ?>
        </div>
        <div class="col-xs-12 col-md-8 pull-left">
            <?php if (!$is_other_user): ?>
                <?php require(__DIR__ . '/../../../../views/site/fragment/video_send.php'); ?>
            <?php endif; ?>
            <?php require(__DIR__ . '/../../../../views/site/fragment/video_search.php'); ?>
            <div class="btn-group">
                <button type="button" class="btn btn-default">全部</button>
                <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
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
            <?php if (!$is_other_user): ?>
                <a href="#send_video" data-toggle="collapse" aria-expanded="false" aria-controls="send_video" role="tab" class="btn btn-default pull-right">我要“发”视频</a>
            <?php endif; ?>
            <a href="#search_video" data-toggle="collapse" aria-expanded="false" aria-controls="search_video" role="tab" class="btn btn-default pull-right">我要“搜”视频</a>
            <?php if (count($user->videos) < 1): ?>
                <div class="alert alert-info" role="alert">还没有发布任何视频</div>
            <?php else: ?>
                <?php foreach ($user->videos as $video_info): ?>
                    <?php require(__DIR__ . '/../../../../views/site/fragment/video_info_panel.php'); ?>
                <?php endforeach; ?>
            <? endif; ?>
        </div>
    </div>
</div>
