<?php
use Yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = Yii::t('app', 'monbile');
?>
<div class="site-index">
    <div class="row">
        <div class="col-md-2">
            <h2 class="text-center text-danger">热门人物</h2>
            <div class="media">
                <div class="media-middle">
                    <a href="#"><img src="/heads/head (1).jpg" alt="..." class="img-circle img-responsiv img-thumbnail"></a>
                </div>
                <div class="media-body text-center">
                    <a href="#" class="btn btn-warning" role="button">+关注<span class="badge">12562</span></a>
                </div>
            </div>
            <div class="media">
                <div class="media-middle">
                    <a href="#"><img src="/heads/head (2).jpg" alt="..." class="img-circle img-responsiv img-thumbnail"></a>
                </div>
                <div class="media-body text-center">
                    <a href="#" class="btn btn-primary" role="button">已关注<span class="badge">12562</span></a>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <ul class="nav nav-pills">
                <li role="presentation" class="active">
                    <a href="#">1小时内</a>
                </li>
                <li role="presentation">
                    <a href="#">24小时内</a>
                </li>
                <li role="presentation">
                    <a href="#">周榜</a>
                </li>
                <li role="presentation">
                    <a href="#">月榜</a>
                </li>
            </ul>
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="media">
                        <div class="media-left">
                            <a href="#"><img src="/heads/head (5).jpg" alt="..."
                                             class="img-circle img-responsiv img-thumbnail"></a>

                            <div class="text-center"><a href="#" class="btn btn-warning" role="button">+关注</a></div>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">超级管理员</h4>

                            <p>哈哈哈哈哈哈哈哈哈哈超级管理员,超级管理员,哈哈哈哈哈哈哈哈哈哈超级管理员@哈哈哈哈哈哈哈哈哈哈超级管理员wa哈哈哈哈哈哈哈哈哈哈超级管理员</p>

                            <div class="">
                                <span class="label label-default">Default</span>
                                <span class="label label-primary">Primary</span>
                                <span class="label label-success">Success</span>
                                <span class="label label-info">Info</span>
                            </div>
                            <div class="media">
                                <div class="media-middle">
                                    <video src="/videos/a.mp4" controls="controls" class="col-xs-12">
                                        <p>您的浏览器不支持html5，请更换浏览器</p>
                                    </video>
                                </div>
                            </div>

                            <div class="row">
                                <h5 class="col-xs-12">
                                    <small>今天 21:35</small>
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="row text-center">
                        <a href="#" class="col-xs-3" role="button">收藏</a>
                        <a href="#" class="col-xs-3" role="button">转发<span class="badge">12562</span></a>
                        <a href="#" class="col-xs-3" role="button">评论<span class="badge">12562</span></a>
                        <a href="#" class="col-xs-3 glyphicon glyphicon-thumbs-up" role="button"><span class="badge">12562</span></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <h2 class="text-center text-danger">热门标签</h2>
            <a href="#" class="btn"><span class="label label-danger">英雄联盟</span></a>
            <a href="#" class="btn"><span class="label label-primary">Dota</span></a>
            <a href="#" class="btn"><span class="label label-success">Success</span></a>
            <a href="#" class="btn"><span class="label label-info">英雄联盟</span></a>
            <a href="#" class="btn"> <span class="label label-default">Default</span></a>
            <a href="#" class="btn"><span class="label label-primary">Primary</span></a>
            <a href="#" class="btn"><span class="label label-success">Success</span></a>
            <a href="#" class="btn"><span class="label label-info">Info</span></a>
        </div>
    </div>
</div>
