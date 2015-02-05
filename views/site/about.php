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
    <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" aria-expanded="false"
       aria-controls="collapseExample">
        Link with href
    </a>
    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample"
            aria-expanded="false" aria-controls="collapseExample">
        Button with data-target
    </button>
    <div class="collapse" id="collapseExample">
        <div class="well">
            ...
        </div>
    </div>

    <br/>
    <a href="<?= Url::to(['/site/mail']) ?>">发邮件</a>

    <br/>
    <?php echo date('Y-m-d H:i:s'); ?>

    <br/>
    <?php echo md5(md5('admin')) ?>
    <br/>
    <?php echo md5(12345) ?>

    <br/>
    <!--    --><?php //require(__DIR__.'/fragment/video_send.php');?>

    <br/>
    <?php
    $tags = '111#sss#asad#';
    $arr = explode("#", $tags);
    for ($index = 0; $index < count($arr) - 1; $index++) {
        echo $arr[$index];
        echo "</br>";
    }
    ?>

    <br/>
    <?php
    $time = time() - strtotime('2015-02-05 19:57:12');
    $yourday = (int)($time / (3600 * 24));
    $yourhour = (int)(($time % (3600 * 24)) / (3600));
    $yourmin = (int)($time % (3600) / 60);
    echo $yourday . '天' . $yourhour . '小时' . $yourmin . '分';

    ?>
</div>
