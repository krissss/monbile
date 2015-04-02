<?php
/**
 * 个人粉丝 or XX的粉丝
 */
/* @var $this \yii\web\View */
/* @var $relations_array :: render */
/* 若是查看自己的粉丝，需以下变量 */
/* @var $user :: session */
/* @var $is_other_user :: false :: 相对user_info.php那块而言 */
/* 若是查看他人粉丝，需以下变量 */
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

$this->title = $user->nickname.'的粉丝';
?>
<div class="user-default-relations-back">
    <div class="row">
        <div class="col-xs-12 col-md-8">
            <div class="row">
                <?php if (count($user->relationsBack) < 1): ?>
                    <div class="alert alert-info col-xs-12" role="alert">还没有任何粉丝</div>
                <?php else: ?>
                    <?php foreach ($user->relationsBack as $relationBack): ?>
                        <?php $user_relation = $relationBack->front?>
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