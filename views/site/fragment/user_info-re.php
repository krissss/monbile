<?php
/**
 * 用户信息
 * site/index   user/default/index  user/default/videos
 * 在包含页面需定义以下变量
 */
/* @var $user :: session or render($other_user) */
/* @var $is_other_user :: false or true */
/* @var $relations_array :: render */
/* @var $heads = Url::to('/heads/'); */
/* @var $imgs = Url::to('/imgs/'); */

use yii\helpers\Url;
use app\models\Users;

$imgs = Url::to('/imgs/');
?>
<div class="user-info">
    <div class="text-center">
        <img src="<?= Url::to($heads . $user->head) ?>" alt="<?=$user->nickname?>" title="<?=$user->nickname?>" class="img-circle img-responsiv img_height_150">
        <h3>
            <?php if($user->sex == Users::USER_SEX_MALE):?>
                <strong class="text-primary"><?= $user->nickname ?></strong>
                <div class="self_icon icon_male_circle"></div>
            <?php elseif($user->sex == Users::USER_SEX_FEMALE):?>
                <strong class="text-danger"><?= $user->nickname ?></strong>
                <div class="self_icon icon_female_circle"></div>
            <?php else:?>
                <strong><?= $user->nickname ?></strong>
            <?php endif; ?>
            <?php if($is_other_user):?>
            <a href="javascript:void(0);" class="add_follow" data-user-id="<?=$user->uid?>">
                <?php if(in_array($user->uid,$relations_array,true)):?>
                    <small><span class="label label-warning"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span>已关注</span></small>
                <? else: ?>
                    <small><span class="label label-primary"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>关注</span></small>
                <? endif; ?>
            </a>
            <?php endif; ?>
        </h3>
        <p class="text-muted"><?=$user->introduce?$user->introduce:'这家伙很懒，都懒的介绍自己';?></p>
    </div>
    <div class="panel panel-default">
        <div class="panel-body text-center">
            <div class="col-xs-3"><a href="<?= Url::to(['/user/default/relations-front','id'=>$user->uid]) ?>">关注<span class="badge"><?=count($user->relationsFront)?></span></a></div>
            <div class="col-xs-1">|</div>
            <div class="col-xs-3"><a href="<?= Url::to(['/user/default/relations-back','id'=>$user->uid]) ?>">粉丝<span class="badge fans_<?=$user->uid?>"><?=count($user->relationsBack)?></span></a></div>
            <div class="col-xs-1">|</div>
            <div class="col-xs-3"><a href="<?= Url::to(['/user/default/collections','id'=>$user->uid]) ?>">收藏<span class="badge"><?=count($user->collections)?></span></a></div>
            <div class="col-xs-12 line_horizontal_height_21"></div>
            <div class="col-xs-5"><a href="<?= Url::to(['/user/default/index','id'=>$user->uid]) ?>"><?=$is_other_user?'他的主页':'我的主页'?></a></div>
            <div class="col-xs-1">|</div>
            <div class="col-xs-5"><a href="<?= Url::to(['/user/default/videos','id'=>$user->uid]) ?>"><?=$is_other_user?'他的视频':'我的视频'?><span class="badge"><?=count($user->videos)?></span></a></div>
        </div>
    </div>
</div>