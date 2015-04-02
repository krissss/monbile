<?php
/* @var $user */
/* @var $is_other_user */
/* @var $relations_array */
/* @var $head_path */
/* @var $img_path */

use yii\helpers\Url;
use app\models\Users;
?>
<div class="user-info">
    <div class="text-center">
        <img src="<?= Url::to($head_path . $user->head) ?>" alt="<?=$user->nickname?>" title="<?=$user->nickname?>" class="img-circle img-responsiv img_height_150">
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
            <div class="col-xs-5"><a href="<?= Url::to(['/user/default/relations-front','id'=>$user->uid]) ?>">关注<span class="badge"><?=count($user->relationsFront)?></span></a></div>
            <div class="col-xs-1">|</div>
            <div class="col-xs-5"><a href="<?= Url::to(['/user/default/relations-back','id'=>$user->uid]) ?>">粉丝<span class="badge fans_<?=$user->uid?>"><?=count($user->relationsBack)?></span></a></div>
            <div class="col-xs-12 line_horizontal_height_21"></div>
            <div class="col-xs-5"><a href="<?= Url::to(['/user/default/index','id'=>$user->uid]) ?>"><?=$is_other_user?'他的主页':'我的主页'?><span class="badge"><?=count($user->videos)?></span></a></div>
            <div class="col-xs-1">|</div>
            <div class="col-xs-5"><a href="<?= Url::to(['/user/default/collections','id'=>$user->uid]) ?>"><?=$is_other_user?'他的收藏':'我的收藏'?><span class="badge"><?=count($user->collections)?></span></a></div>
        </div>
    </div>
</div>