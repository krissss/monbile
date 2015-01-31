<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
$this->title = '个人主页';

$imgs = Url::to('/imgs/');
$heads = Url::to('/heads/');
$videos = Url::to('/videos/');
?>
<div class="user-default-index">
    <div class="row">

        <div class="col-xs-12 col-md-8">
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <div class="thumbnail">
                        <video src="<?= Url::to($videos . 'a.mp4') ?>" controls="controls"
                               class="col-xs-12">
                            <p>您的浏览器不支持html5，请更换浏览器</p>
                        </video>
                        <div class="caption">
                            <p>今天 21:35</p>
                            <div class="">
                                <span class="label label-default">Default</span>
                                <span class="label label-primary">Primary</span>
                                <span class="label label-success">Success</span>
                                <span class="label label-info">Info</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="thumbnail">
                        <video src="<?= Url::to($videos . 'a.mp4') ?>" controls="controls"
                               class="col-xs-12">
                            <p>您的浏览器不支持html5，请更换浏览器</p>
                        </video>
                        <div class="caption">
                            <p>今天 21:35</p>
                            <div class="">
                                <span class="label label-default">Default</span>
                                <span class="label label-primary">Primary</span>
                                <span class="label label-success">Success</span>
                                <span class="label label-info">Info</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="thumbnail">
                        <video src="<?= Url::to($videos . 'a.mp4') ?>" controls="controls"
                               class="col-xs-12">
                            <p>您的浏览器不支持html5，请更换浏览器</p>
                        </video>
                        <div class="caption">
                            <p>今天 21:35</p>
                            <div class="">
                                <span class="label label-default">Default</span>
                                <span class="label label-primary">Primary</span>
                                <span class="label label-success">Success</span>
                                <span class="label label-info">Info</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="thumbnail">
                        <video src="<?= Url::to($videos . 'a.mp4') ?>" controls="controls"
                               class="col-xs-12">
                            <p>您的浏览器不支持html5，请更换浏览器</p>
                        </video>
                        <div class="caption">
                            <p>今天 21:35</p>
                            <div class="">
                                <span class="label label-default">Default</span>
                                <span class="label label-primary">Primary</span>
                                <span class="label label-success">Success</span>
                                <span class="label label-info">Info</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-4">
            <div class="text-center">
                <img src="<?= Url::to($heads . 'head (5).jpg') ?>" alt="" class="img-circle img-responsiv img_height_150">

                <h3>超级管理员</h3>
            </div>
            <div class="panel panel-default">
                <div class="panel-body text-center">
                    <div class="col-xs-3">关注<a href="<?= Url::to(['index']) ?>"><span class="badge">45</span></a></div>
                    <div class="col-xs-1">|</div>
                    <div class="col-xs-3">粉丝<a href="<?= Url::to(['index']) ?>"><span class="badge">45</span></a></div>
                    <div class="col-xs-1">|</div>
                    <div class="col-xs-3">动态<a href="<?= Url::to(['index']) ?>"><span class="badge">45</span></a></div>
                    <div class="col-xs-12 line_horizontal_height_21"></div>
                    <div class="col-xs-5"><a href="<?= Url::to(['index']) ?>">我的主页</a></div>
                    <div class="col-xs-1">|</div>
                    <div class="col-xs-5"><a href="<?= Url::to(['videos']) ?>">我的视频</a></div>
                </div>
            </div>
        </div>
    </div>
</div>
