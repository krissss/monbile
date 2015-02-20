<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use \app\models\Users;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
$imgs = Url::to('/imgs/');
$heads = Url::to('/heads/');
$videos = Url::to('/videos/');

$user = Yii::$app->getSession()->get('user');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>

<?php $this->beginBody() ?>
    <div class="wrap">
        <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?=Url::to(['/site/index'])?>"><img src="<?=Url::to($imgs.'logo-word-28.png')?>" alt="monbile" title="monbile"></a>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="<?=Url::to(['/site/index'])?>"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>首页</a></li>
                        <?/**类型暂时只用英雄联盟,需要选择类型打开以下注释
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-facetime-video" aria-hidden="true"></span>游戏分类<span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#">英雄联盟</a></li>
                                <li><a href="#">Dota</a></li>
                                <li><a href="#">炉石传说</a></li>
                            </ul>
                        </li>
                         */?>
                        <li><a href="<?=Url::to(['/site/about'])?>"><span class="glyphicon glyphicon-alert" aria-hidden="true"></span>测试代码</a></li>
                        <?php if(!$user):?>
                        <li><a href="<?=Url::to(['/site/register'])?>"><span class="glyphicon glyphicon-registration-mark" aria-hidden="true"></span>注册</a></li>
                        <li><a href="<?=Url::to(['/site/login'])?>"><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span>登录</a></li>
                        <?php else: ?>
                            <li class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-user" aria-hidden="true"></span><?=$user->nickname?><span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="<?=Url::to(['/user/default/index'])?>">我的主页</a></li>
                                    <li><a href="<?=Url::to(['/user/default/videos'])?>">我的视频</a></li>
                                    <li><a href="<?=Url::to(['/user/default/collections'])?>">我的收藏</a></li>
                                    <li><a href="<?=Url::to(['/user/default/relations-front'])?>">我的关注</a></li>
                                    <li><a href="<?=Url::to(['/user/default/relations-back'])?>">我的粉丝</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span>个人设置<span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="<?=Url::to(['/user/default/update-paw'])?>">修改密码</a></li>
                                    <li><a href="<?=Url::to(['/user/default/update-head'])?>">修改头像</a></li>
                                    <li><a href="<?=Url::to(['/user/default/update-info'])?>">修改信息</a></li>
                                </ul>
                            </li>
                            <?php if(Users::isUserSuperAdmin($user)):?>
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span>超级管理员操作<span class="caret"></span></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="<?=Url::to(['/superAdmin/default/index'])?>">主页</a></li>
                                    </ul>
                                </li>
                            <?php endif; ?>
                            <li><a href="<?=Url::to(['/site/logout'])?>"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>退出</a></li>
                        <?php endif;?>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; My Company <?= date('Y') ?></p>
            <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
