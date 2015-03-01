<?php
/**
 * 点击评论的弹出框
 * site/index   user/default/index  user/default/collections
 * 在包含页面需定义以下变量
 */
/* @var $session_user :: session */

use \yii\helpers\Url;
?>

<div class="modal fade" id="commentsModal" tabindex="-1" role="dialog" aria-labelledby="commentsModalLabel" aria-hidden="true" aria-describedby="弹出的评论框">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span data-dismiss="modal" class="glyphicon glyphicon-remove cursor_pointer pull-right" aria-hidden="true" title="关闭"></span>
                <span class="glyphicon glyphicon-refresh pull-right margin_right_20 cursor_pointer comments_refresh" aria-hidden="true" title="刷新"></span>
                <h5 class="modal-title" id="myModalLabel">评论</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <input type="hidden" value="" class="comment_video_id" >
                    <input type="hidden" value="" class="comment_to_user_id" >
                    <?php if($session_user): ?>
                    <div class="col-xs-1 text-center">
                        <img src="<?= Url::to($heads . $session_user->head) ?>" alt="<?=$session_user->nickname?>" title="<?=$session_user->nickname?>" class="img-circle img-responsiv img_height_35">
                    </div>
                    <form class="form form-group col-xs-11">
                        <div class="input-group">
                            <input type="text" class="form-control comment_content" placeholder="30字以内" maxlength="30">
                            <span class="input-group-btn">
                                <button class="btn btn-primary comment_send" type="button">OK</button>
                            </span>
                        </div>
                    </form>
                    <?php endif; ?>
                </div>
            </div>
            <div class="comments_list"></div>
        </div>
    </div>
</div>