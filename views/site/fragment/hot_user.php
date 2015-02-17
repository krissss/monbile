<?php
/**
 * 热门标签
 * site/index
 * 在包含页面需定义以下变量
 */
/* @var $users_hot :: session */
/* @var $relations_array :: render */

use yii\helpers\Url;

$session_user = Yii::$app->getSession()->get('user');
?>

<div class="hot-tag">
    <div class="panel panel-default">
        <div class="panel-body">
            <h2 class="text-center text-danger">风云人物</h2>
            <?php $fans_number = 0;//作用：用于判断当下一个用户的粉丝数和上一个一样，但已经超过10位，此时还是会将该用户列出来?>
            <?php for ($i=0 ; $i<count($users_hot) && ($i<10 || $fans_number==$users_hot[$i]['relationsBack']); $i++): ?>
            <?php $user_hot = $users_hot[$i]['user']; ?>
                <div class="media panel">
                    <div class="panel-body">
                        <div class="media-left">
                            <a href="<?= Url::to(['/user/default/index', 'id' => $user_hot->uid]) ?>">
                                <img src="<?= Url::to($heads . $user_hot->head) ?>" alt="<?= $user_hot->nickname ?>" title="<?= $user_hot->nickname ?>" class="img-circle img-responsiv img_height_80">
                            </a>
                        </div>
                        <div class="media-body">
                            <a href="<?= Url::to(['/user/default/index', 'id' => $user_hot->uid]) ?>">
                                <h4 class="media-heading"><?= $user_hot->nickname ?></h4>
                            </a>
                            <h5>
                                <a href="javascript:void(0);" class="add_follow" data-user-id="<?=$session_user&&$user_hot->uid == $session_user->uid?'':$user_hot->uid?>">
                                    <?php if($session_user&&$user_hot->uid == $session_user->uid):?>
                                        <small><span class="label label-danger"><span class="glyphicon glyphicon-heart" aria-hidden="true"></span>这是我</span></small>
                                    <?php elseif(in_array($user_hot->uid,$relations_array,true)):?>
                                        <small><span class="label label-warning"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span>已关注</span></small>
                                    <?php else: ?>
                                        <small><span class="label label-primary"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>关注</span></small>
                                    <?php endif; ?>
                                </a>
                            </h5>
                            <div class="col-xs-6"><a href="<?= Url::to(['/user/default/relations-back','id'=>$user_hot->uid]) ?>">粉丝<span class="badge fans_<?=$user_hot->uid?>"><?=$fans_number=count($user_hot->relationsBack)?></span></a></div>
                            <div class="col-xs-6"><a href="<?= Url::to(['/user/default/videos','id'=>$user_hot->uid]) ?>">视频<span class="badge"><?=count($user_hot->videos)?></span></a></div>
                        </div>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
    </div>
</div>