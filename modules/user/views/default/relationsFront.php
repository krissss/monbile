<?php
/**
 * 个人关注 or XX的关注
 */
/* @var $this \yii\web\View */
/* @var $relations_array :: render */
/* 若是查看自己的关注，需以下变量 */
/* @var $user :: session */
/* @var $is_other_user :: false :: 相对user_info.php那块而言 */
/* 若是查看他人关注，需以下变量 */
/* @var $user :: render($other_user) */
/* @var $is_other_user :: true :: 相对user_info.php那块而言 */

use yii\helpers\Url;

$heads = Url::to('/heads/');

$session = Yii::$app->getSession();
$session_user = $session->get('user');
$user = $session_user;

$is_other_user = false;
if(isset($other_user)&&$other_user){
    $user = $other_user;
    $is_other_user = true;
}

$this->title = $user->nickname.'的关注';
?>
<div class="user-default-relations-front">
    <div class="row">
        <div class="col-xs-12 col-md-8">
            <div class="row">
                <?php if (count($user->relationsFront) < 1): ?>
                    <div class="alert alert-info col-xs-12" role="alert">还没有关注任何人</div>
                <?php else: ?>
                    <?php foreach ($user->relationsFront as $relationFront): ?>
                        <?php $user_relation = $relationFront->back?>
                        <div class="col-xs-12 col-md-6">
                            <?php /*require(__DIR__ . '/../../../../views/site/fragment/user_relation_info.php'); */?>
                            <?=\app\widgets\UserRelationInfoWidget::widget(['user_relation'=>$user_relation])?>
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