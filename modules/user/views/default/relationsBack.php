<?php
/**
 * 个人粉丝 or XX的粉丝
 */
/* @var $this \yii\web\View */
/* @var $relations_array :: render */
/* 若是查看自己的粉丝，需以下变量 */
/* @var $user :: session */
/* @var $is_other_user :: false; */
/* 若是查看他人粉丝，需以下变量 */
/* @var $user :: render($other_user) */
/* @var $is_other_user :: true; */

use yii\helpers\Url;

$heads = Url::to('/heads/');

$session = Yii::$app->getSession();
$user = $session->get('user');
$session_user = $user;

$is_other_user = false;
if(isset($other_user)&&$other_user){
    $user = $other_user;
    $is_other_user = true;
}

$this->title = $user->nickname.'的粉丝';
?>
<div class="user-default-videos">
    <div class="row">
        <div class="col-xs-12 col-md-8">
            <div class="row">
                <?php if (count($user->relationsBack) < 1): ?>
                    <div class="alert alert-info col-xs-12" role="alert">还没有任何粉丝</div>
                <?php else: ?>
                    <?php foreach ($user->relationsBack as $relationBack): ?>
                        <div class="col-xs-12 col-md-6">
                            <div class="media panel">
                                <div class="panel-body">
                                    <div class="media-left">
                                        <a href="<?= Url::to(['/user/default/index', 'id' => $relationBack->front->uid]) ?>">
                                            <img src="<?= Url::to($heads . $relationBack->front->head) ?>" alt="<?= $relationBack->front->nickname ?>" title="<?= $relationBack->front->nickname ?>" class="img-circle img-responsiv img_height_80">
                                        </a>
                                    </div>
                                    <div class="media-body">
                                        <a href="<?= Url::to(['/user/default/index', 'id' => $relationBack->front->uid]) ?>">
                                            <h4 class="media-heading"><?= $relationBack->front->nickname ?></h4>
                                        </a>
                                        <h5><a href="javascript:void(0);" class="add_follow" data-user-id="<?=$session_user&&$relationBack->front->uid == $session_user->uid?'':$relationBack->front->uid?>">
                                                <?php if($session_user&&$relationBack->front->uid == $session_user->uid):?>
                                                    <small><span class="label label-danger"><span class="glyphicon glyphicon-heart" aria-hidden="true"></span>这是我</span></small>
                                                <?php elseif(in_array($relationBack->front->uid,$relations_array,true)):?>
                                                    <small><span class="label label-warning"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span>已关注</span></small>
                                                <? else: ?>
                                                    <small><span class="label label-primary"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>关注</span></small>
                                                <? endif; ?>
                                            </a></h5>
                                        <div class="col-xs-6"><a href="<?= Url::to(['/user/default/videos','id'=>$relationBack->front->uid]) ?>">视频<span class="badge"><?=count($relationBack->front->videos)?></span></a></div>
                                        <div class="col-xs-6"><a href="<?= Url::to(['/user/default/collections','id'=>$relationBack->front->uid]) ?>">收藏<span class="badge"><?=count($relationBack->front->collections)?></span></a></div>
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