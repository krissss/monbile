<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
$this->title = '个人主页';

$imgs = Url::to('/imgs/');
$heads = Url::to('/heads/');
$videos = Url::to('/videos/');

$user = Yii::$app->getSession()->get('user');
?>
<div class="user-default-index">
    <div class="row">
        <?php if($user && $user->create_date == $user->update_date): ?>
            <div class="alert alert-warning alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <strong>警告!</strong>
                &nbsp;&nbsp;&nbsp;&nbsp;您的密码未修改，存在不安全因素，也可能给您下次登录带来麻烦，请尽快修改。&nbsp;&nbsp;&nbsp;&nbsp;
                <Strong><a href="<?=Url::to(['/site/about'])?>" class="alert-link">点我修改</a></Strong>
            </div>
        <?php endif; ?>
        <div class="col-xs-12 col-md-8">
            <div class="btn-group">
                <button type="button" class="btn btn-default btn-sm">全部</button>
                <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown"
                        aria-expanded="false">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu" role="menu">
                    <li role="presentation"><a role="menuitem" tabindex="-2" href="#">全部</a></li>
                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#">原创</a></li>
                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#">转发</a></li>
                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#">收藏</a></li>
                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#">标签</a></li>
                </ul>
            </div>
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="media">
                        <div class="media-left">
                            <a href="#"><img src="<?= Url::to($heads . 'head (4).jpg') ?>" alt="..."
                                             class="img-circle img-responsiv img_height_80"></a>
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
                                    <video src="<?= Url::to($videos . 'a.mp4') ?>" controls="controls"
                                           class="col-xs-12">
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
            </div>
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="media">
                        <div class="media-left">
                            <a href="#"><img src="<?= Url::to($heads . 'head (4).jpg') ?>" alt="..."
                                             class="img-circle img-responsiv img_height_80"></a>
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
                                    <video src="<?= Url::to($videos . 'a.mp4') ?>" controls="controls"
                                           class="col-xs-12">
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
            </div>
        </div>
        <div class="col-xs-12 col-md-4">
           <?php require(__DIR__.'/../../../../views/site/fragment/user_info.php');?>
        </div>
    </div>
</div>
