<?php
/* @var $user_relation */
/* @var $relations_array */
/* @var $session_user */
/* @var $is_hot_user */

use yii\helpers\Url;
use app\models\Users;

?>

<div class="media panel">
    <div class="panel-body">
        <div class="media-left">
            <a href="<?= Url::to(['/user/default/index', 'id' => $user_relation->uid]) ?>">
                <img src="<?= Url::to($heads . $user_relation->head) ?>" alt="<?= $user_relation->nickname ?>" title="<?= $user_relation->nickname ?>" class="img-circle img-responsiv img_height_80">
            </a>
        </div>
        <div class="media-body">
            <a href="<?= Url::to(['/user/default/index', 'id' => $user_relation->uid]) ?>">
                <h4 class="media-heading">
                    <?php if($user_relation->sex == Users::USER_SEX_MALE):?>
                        <strong class="text-primary"><?= $user_relation->nickname ?></strong>
                        <div class="self_icon icon_male"></div>
                    <?php elseif($user_relation->sex == Users::USER_SEX_FEMALE):?>
                        <strong class="text-danger"><?= $user_relation->nickname ?></strong>
                        <div class="self_icon icon_female"></div>
                    <?php else:?>
                        <strong><?= $user_relation->nickname ?></strong>
                    <?php endif; ?>
                </h4>
            </a>
            <h5><a href="javascript:void(0);" class="add_follow" data-user-id="<?=$session_user&&$user_relation->uid == $session_user->uid?'':$user_relation->uid?>">
                    <?php if($session_user&&$user_relation->uid == $session_user->uid):?>
                        <small><span class="label label-danger"><span class="glyphicon glyphicon-heart" aria-hidden="true"></span>这是我</span></small>
                    <?php elseif(in_array($user_relation->uid,$relations_array,true)):?>
                        <small><span class="label label-warning"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span>已关注</span></small>
                    <?php else: ?>
                        <small><span class="label label-primary"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>关注</span></small>
                    <?php endif; ?>
                </a></h5>
            <p class="text-muted"><?=$user_relation->introduce?$user_relation->introduce:'这家伙很懒，都懒的介绍自己';?></p>
            <div class="col-xs-6"><a href="<?= Url::to(['/user/default/index','id'=>$user_relation->uid]) ?>">视频<span class="badge"><?=count($user_relation->videos)?></span></a></div>
            <?php if($is_hot_user):?>
                <div class="col-xs-6"><a href="<?= Url::to(['/user/default/relations-back','id'=>$user_relation->uid]) ?>">粉丝<span class="badge fans_<?=$user_relation->uid?>"><?=$fans_number=count($user_relation->relationsBack)?></span></a></div>
            <? else: ?>
                <div class="col-xs-6"><a href="<?= Url::to(['/user/default/collections','id'=>$user_relation->uid]) ?>">收藏<span class="badge"><?=count($user_relation->collections)?></span></a></div>
            <?php endif; ?>
        </div>
    </div>
</div>