<?php
/**
 * 消息页面
 */
/* @var $this \yii\web\View */

use yii\helpers\Url;

$heads = Url::to('/heads/');
$videos = Url::to('/videos/');

$this->title = '消息';

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
                <?//未读消息?>
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
                                            <h3><?=$message->message_content?><small class="pull-right">&nbsp;&nbsp;&nbsp;&nbsp;—<?= $message->message_title;?></small></h3>
                                            <div class="replay-form">
                                                <div class="has_face">相关视频：<a href="<?=Url::to(['/site/video','id'=>$message->about_video_id])?>">#<?=$message->aboutVideo->video_title?></a></div>
                                                <br/>
                                                <form class="form form-group col-xs-11">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control comment_content" placeholder="30字以内" maxlength="30" data-comment-video-id="<?=$message->about_video_id?>" data-comment-to-user-id="<?=$message->fromUser->uid?>" data-comment-parent-id="<?=$message->about_comment_id?>">
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-primary comment_send" type="button">回复</button>
                                                        </span>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach; ?>
                        </ul>
                    </section>
                </div>
                <?//全部消息?>
                <div role="tabpanel" class="tab-pane fade" id="read">
                    <section class="message_timeline">
                    <ul class="timeline">
                    <?php foreach ($messagesTotal as $message): ?>
                        <?//if(isset($message->aboutComment->parent_id) && $message->aboutComment->parent_id!=0){ continue;}?>
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
                                        <h3><?=$message->message_content?><small class="pull-right">&nbsp;&nbsp;&nbsp;&nbsp;—<?= $message->message_title;?></small></h3>
                                        <div class="replay-form">
                                            <div class="has_face">相关视频：<a href="<?=Url::to(['/site/video','id'=>$message->about_video_id])?>">#<?=$message->aboutVideo->video_title?></a></div>
                                            <br/>
                                            <form class="form form-group col-xs-11">
                                                <div class="input-group">
                                                    <input type="text" class="form-control comment_content" placeholder="30字以内" maxlength="30" data-comment-video-id="<?=$message->about_video_id?>" data-comment-to-user-id="<?=$message->fromUser->uid?>" data-comment-parent-id="<?=$message->about_comment_id?>">
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-primary comment_send" type="button">回复</button>
                                                        </span>
                                                </div>
                                            </form>
                                        </div>
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