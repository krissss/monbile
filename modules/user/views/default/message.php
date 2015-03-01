<?php
/**
 * 筛选榜单
 */
/* @var $this \yii\web\View */
/* @var $tops_info :: render */

use yii\helpers\Url;

$heads = Url::to('/heads/');
$videos = Url::to('/videos/');

$this->title = '筛选榜单';

$messagesUnRead = Yii::$app->getSession()->get('user')->messagesUnRead;
$messagesTotal = Yii::$app->getSession()->get('user')->messagesTotal;
?>
<div class="user-default-messages">
    <div class="row">
        <div role="tabpanel">
            <ul class="nav nav-pills" role="tablist">
                <li role="presentation" class="active"><a href="#unRead" aria-controls="one_hour" role="tab" data-toggle="tab">未读消息</a></li>
                <li role="presentation"><a href="#read" aria-controls="one_hour" role="tab" data-toggle="tab">全部消息</a></li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active" id="unRead">
                    <section class="message_timeline">
                        <ul class="timeline">
                    <?php foreach ($messagesUnRead as $message): ?>
                        <li class="event">
                            <input type="radio" name="tl-group" checked/>
                            <label></label>
                            <div class="thumb">
                                <a href="<?=Url::to(['/user/default/index','id'=>$message->fromUser->uid])?>">
                                    <img src="<?= Url::to($heads . $message->fromUser->head) ?>" alt="<?= $message->fromUser->nickname ?>" title="<?= $message->fromUser->nickname ?>" class="img-circle img-responsiv img_height_100">
                                </a>
                                <span class="time"><?=$message->message_date?></span>
                            </div>
                            <div class="content-perspective">
                                <div class="content">
                                    <div class="content-inner">
                                        <h3><?=$message->message_content?></h3>
                                        <p>Don't be too proud of this technological terror you've constructed. The ability to destroy a planet is insignificant next to the power of the Force. The plans you refer to will soon be back in our hands. A tremor in the Force. The last time I felt it was in the presence of my old master. Escape is not his plan. I must face him. Alone.</p>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                        </ul>
                    </section>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="read">
                    <section class="message_timeline">
                    <ul class="timeline">
                    <?php foreach ($messagesTotal as $message): ?>
                        <li class="event">
                            <input type="radio" name="tl-group" checked/>
                            <label></label>
                            <div class="thumb">
                                <a href="<?=Url::to(['/user/default/index','id'=>$message->fromUser->uid])?>">
                                    <img src="<?= Url::to($heads . $message->fromUser->head) ?>" alt="<?= $message->fromUser->nickname ?>" title="<?= $message->fromUser->nickname ?>" class="img-circle img-responsiv img_height_100">
                                </a>
                                <span class="time"><?=$message->message_date?></span>
                            </div>
                            <div class="content-perspective">
                                <div class="content">
                                    <div class="content-inner">
                                        <h3><?=$message->message_content?></h3>
                                        <p>Don't be too proud of this technological terror you've constructed. The ability to destroy a planet is insignificant next to the power of the Force. The plans you refer to will soon be back in our hands. A tremor in the Force. The last time I felt it was in the presence of my old master. Escape is not his plan. I must face him. Alone.</p>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                    </ul>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>