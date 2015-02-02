<?php
/**
 * Created by PhpStorm.
 * User: kriss
 * Date: 2015/2/2
 * Time: 14:27
 */
use yii\helpers\Url;

$heads = Url::to('/heads/');
$user = Yii::$app->getSession()->get('user');
?>
<div class="user-info">
    <div class="text-center">
        <a href="<?= Url::to(['/user/default/index']) ?>">
            <img src="<?= Url::to($heads . $user->head) ?>" alt=""
                 class="img-circle img-responsiv img_height_150">
        </a>

        <h3><?= $user->nickname ?></h3>
    </div>
    <div class="panel panel-default">
        <div class="panel-body text-center">
            <div class="col-xs-3">关注<a href="<?= Url::to(['/user/default/index']) ?>"><span class="badge">45</span></a>
            </div>
            <div class="col-xs-1">|</div>
            <div class="col-xs-3">粉丝<a href="<?= Url::to(['/user/default/index']) ?>"><span class="badge">45</span></a>
            </div>
            <div class="col-xs-1">|</div>
            <div class="col-xs-3">动态<a href="<?= Url::to(['/user/default/index']) ?>"><span class="badge">45</span></a>
            </div>
            <div class="col-xs-12 line_horizontal_height_21"></div>
            <div class="col-xs-5"><a href="<?= Url::to(['/user/default/index']) ?>">我的主页</a></div>
            <div class="col-xs-1">|</div>
            <div class="col-xs-5"><a href="<?= Url::to(['/user/default/videos']) ?>">我的视频</a></div>
        </div>
    </div>
</div>