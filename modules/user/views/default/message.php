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
                    <div class="timeline animated">
                    <?php foreach ($messagesUnRead as $message): ?>
                        <div class="timeline-row">
                            <!--<div class="timeline-time"><small>Oct 30</small>4:53 PM</div>-->
                            <div class="timeline-time"><?=$message->message_date?></div>
                            <div class="timeline-icon">
                                <a href="<?=Url::to(['/user/default/index','id'=>$message->fromUser->uid])?>">
                                    <img src="<?= Url::to($heads . $message->fromUser->head) ?>" alt="<?= $message->fromUser->nickname ?>" title="<?= $message->fromUser->nickname ?>" class="img-circle img-responsiv img_height_50">
                                </a>
                            </div>
                            <div class="panel panel-default timeline-content">
                                <div class="panel-body">
                                    <h4><?=$message->message_content?></h4>
                                    <h4><small>&nbsp;&nbsp;&nbsp;&nbsp;——<?=$message->message_title?></small></h4>
                                    <h5><a href="<?=Url::to('')?>" class="has_face">#<?=$message->aboutVideo->video_title?></a></h5>
                                    <video data-src="<?= Url::to($videos . $message->aboutVideo->video_path) ?>" controls="controls" class="col-xs-12 lazyload">
                                        <p>您的浏览器不支持html5，请更换浏览器</p>
                                    </video>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="read">
                    <div class="timeline animated">
                    <?php foreach ($messagesTotal as $message): ?>
                        <div class="timeline-row">
                            <!--<div class="timeline-time"><small>Oct 30</small>4:53 PM</div>-->
                            <div class="timeline-time"><?=$message->message_date?></div>
                            <div class="timeline-icon">
                                <a href="<?=Url::to(['/user/default/index','id'=>$message->fromUser->uid])?>">
                                    <img src="<?= Url::to($heads . $message->fromUser->head) ?>" alt="<?= $message->fromUser->nickname ?>" title="<?= $message->fromUser->nickname ?>" class="img-circle img-responsiv img_height_50">
                                </a>
                            </div>
                            <div class="panel panel-default timeline-content">
                                <div class="panel-body">
                                    <h4><?=$message->message_content?></h4>
                                    <h4><small>&nbsp;&nbsp;&nbsp;&nbsp;——<?=$message->message_title?></small></h4>
                                    <h5><a href="<?=Url::to('')?>" class="has_face">#<?=$message->aboutVideo->video_title?></a></h5>
                                    <video data-src="<?= Url::to($videos . $message->aboutVideo->video_path) ?>" controls="controls" class="col-xs-12 lazyload">
                                        <p>您的浏览器不支持html5，请更换浏览器</p>
                                    </video>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>