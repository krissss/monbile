<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#commentsModal">
        Launch demo modal
    </button>

    <!-- Modal -->
    <div class="modal fade" id="commentsModal" tabindex="-1" role="dialog" aria-labelledby="commentsModalLabel"
         aria-hidden="true" aria-describedby="弹出的评论框">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h5 class="modal-title" id="myModalLabel">评论</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-1 text-center"><img class="img_height_35" src="heads/head (1).jpg" alt="...">
                        </div>
                        <form class="form form-group col-xs-11">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search for...">
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="button">OK</button>
                            </span>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="comments_list">
                    <div class="comments_item">
                        <div class="media">
                            <div class="media-left">
                                <a href="#">
                                    <img class="media-object img_height_35" src="heads/head (1).jpg" alt="...">
                                </a>
                            </div>
                            <div class="media-body">
                                <p><span class="text-danger">飒沓</span> : 哈哈哈</p>
                                <h5><small>2015-12-12 10:10:20</small></h5>
                            </div>
                        </div>
                    </div>
                    <div class="comments_item">
                        <div class="media">
                            <div class="media-left">
                                <a href="#">
                                    <img class="media-object img_height_35" src="heads/head (1).jpg" alt="...">
                                </a>
                            </div>
                            <div class="media-body">
                                <p><span class="text-danger">阿打死我</span> ：霍霍霍霍霍霍霍霍霍霍霍霍霍霍霍霍霍霍霍霍霍霍霍</p>
                                <h5><small>22:25</small></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
