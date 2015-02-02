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
            <?php require(__DIR__.'/../../../../views/site/fragment/user_info.php');?>
        </div>
    </div>
</div>
