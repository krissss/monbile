<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        This is the About page. You may modify the following file to customize its content:
    </p>
    <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
        Link with href
    </a>
    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
        Button with data-target
    </button>
    <div class="collapse" id="collapseExample">
        <div class="well">
            ...
        </div>
    </div>

    <br/>
    <a href="<?=Url::to(['/site/mail'])?>">发邮件</a>

    <br/>
    <?php echo date('Y-m-d H:i:s'); ?>

    <br/>
    <?php echo md5(md5('admin'))?>
    <br/>
    <?php echo md5(12345)?>

    <br/>
<!--    --><?php //require(__DIR__.'/fragment/video_send.php');?>
</div>
