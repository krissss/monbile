<?php
/**
 * 用户信息
 * site/index   user/default/index  user/default/videos
 * 在包含页面需定义以下变量
 */
/* @var $user :: session or render($other_user) */
/* @var $is_other_user :: false or true */
/* @var $heads = Url::to('/heads/'); */

use yii\helpers\Url;

?>
<div class="user-info">
    <div class="text-center">
        <a href="<?= Url::to(['/user/default/index']) ?>">
            <img src="<?= Url::to($heads . $user->head) ?>" alt="<?=$user->nickname?>" title="<?=$user->nickname?>" class="img-circle img-responsiv img_height_150">
        </a>
        <h3><?= $user->nickname ?><?php if($is_other_user):?><small><span class="label label-primary"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>关注</span></small><?php endif; ?></h3>
    </div>
    <div class="panel panel-default">
        <div class="panel-body text-center">
            <div class="col-xs-3">关注<a href="<?= Url::to(['/user/default/index']) ?>"><span class="badge"><?=count($user->relationsFront)?></span></a>
            </div>
            <div class="col-xs-1">|</div>
            <div class="col-xs-3">粉丝<a href="<?= Url::to(['/user/default/index']) ?>"><span class="badge"><?=count($user->relationsBack)?></span></a>
            </div>
            <div class="col-xs-1">|</div>
            <div class="col-xs-3">动态<a href="<?= Url::to(['/user/default/index','id'=>$user->uid]) ?>"><span class="badge"><?=count($user->videos)?></span></a>
            </div>
            <div class="col-xs-12 line_horizontal_height_21"></div>
            <div class="col-xs-5"><a href="<?= Url::to(['/user/default/index','id'=>$user->uid]) ?>"><?=$is_other_user?'他的主页':'我的主页'?></a></div>
            <div class="col-xs-1">|</div>
            <div class="col-xs-5"><a href="<?= Url::to(['/user/default/videos','id'=>$user->uid]) ?>"><?=$is_other_user?'他的视频':'我的视频'?></a></div>
        </div>
    </div>
</div>