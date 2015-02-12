<?php
/**
 * 点击评论的弹出框
 * site/index   user/default/index
 * 在包含页面需定义以下变量
 */
/* @var $user :: session */

use \yii\helpers\Url;
?>

<div class="modal fade" id="commentsModal" tabindex="-1" role="dialog" aria-labelledby="commentsModalLabel" aria-hidden="true" aria-describedby="弹出的评论框">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title" id="myModalLabel">评论</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <input type="hidden" value="" class="comment_video_id" >
                    <?php if($user): ?>
                    <div class="col-xs-1 text-center">
                        <img src="<?= Url::to($heads . $user->head) ?>" alt="<?=$user->nickname?>" title="<?=$user->nickname?>" class="img-circle img-responsiv img_height_35">
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