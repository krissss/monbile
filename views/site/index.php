<?php
use Yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
$this->title = Yii::t('app', 'monbile');
$heads = Url::to('/heads/');
$videos = Url::to('/videos/');
$user = Yii::$app->getSession()->get('user');
?>
<div class="site-index">
    <div class="row">
        <div id="error_message" class="alert alert-danger alert-dismissible display_none" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span
                    class="sr-only">Close</span></button>
        </div>
        <?php if (isset($message) && $message): ?>
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <strong><?= $message ?></strong>
            </div>
        <?php endif; ?>
        <div class="col-xs-12 col-md-8">
            <?php if ($user): ?>
                <?php require(__DIR__ . '/fragment/video_send.php'); ?>
            <?php endif; ?>

            <div role="tabpanel">
                <!-- Nav tabs -->
                <ul class="nav nav-pills" role="tablist">
                    <li role="presentation" class="active"><a href="#one_hour" aria-controls="one_hour" role="tab"
                                                              data-toggle="tab">1小时内</a></li>
                    <li role="presentation"><a href="#one_day" aria-controls="one_day" role="tab" data-toggle="tab">24小时内</a>
                    </li>
                    <li role="presentation"><a href="#one_week" aria-controls="one_week" role="tab"
                                               data-toggle="tab">周榜</a></li>
                    <li role="presentation"><a href="#one_month" aria-controls="one_month" role="tab" data-toggle="tab">月榜</a>
                    </li>
                    <?php if ($user): ?>
                        <li role="presentation" class="pull-right"><a href="#send_video" data-toggle="collapse"
                                                                      aria-expanded="false" aria-controls="send_video"
                                                                      role="tab">我要发视频</a></li>
                    <?php endif; ?>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade in active" id="one_hour">
                                <?php foreach ($videos_info as $video_info): ?>
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <div class="media">
                                            <div class="media-left">
                                                <a href="#"><img src="<?= Url::to($heads . $video_info->user->head) ?>"
                                                                 alt="..."
                                                                 class="img-circle img-responsiv img_height_80"></a>
                                            </div>
                                            <div class="media-body">
                                                <h4 class="media-heading">超级管理员</h4>

                                                <p class="has_face"><?= $video_info->video_title ?></p>

                                                <div class="">
                                                    <span class="label label-default">Default</span>
                                                    <span class="label label-primary">Primary</span>
                                                    <span class="label label-success">Success</span>
                                                    <span class="label label-info">Info</span>
                                                </div>
                                                <div class="media">
                                                    <div class="media-middle">
                                                        <video src="<?= Url::to($videos . $video_info->video_path) ?>"
                                                               controls="controls"
                                                               class="col-xs-12">
                                                            <p>您的浏览器不支持html5，请更换浏览器</p>
                                                        </video>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <h5 class="col-xs-12">
                                                        <small><?= (int)((time() - strtotime($video_info->video_date)) % (3600) / 60); ?>
                                                            分钟前
                                                        </small>
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer">
                                        <div class="row text-center">
                                            <a href="#" class="col-xs-3" role="button">收藏</a>
                                            <a href="#" class="col-xs-3" role="button">转发<span
                                                    class="badge"><?= $video_info->forward_count ?></span></a>
                                            <a href="#" class="col-xs-3" role="button">评论<span
                                                    class="badge"><?= $video_info->forward_count ?></span></a>
                                            <a href="#" class="col-xs-3 glyphicon glyphicon-thumbs-up"
                                               role="button"><span class="badge"><?= $video_info->praise_count ?></span></a>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="one_day">
                                <?php foreach ($videos_info as $video_info): ?>
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <div class="media">
                                            <div class="media-left">
                                                <a href="#"><img src="<?= Url::to($heads . $video_info->user->head) ?>"
                                                                 alt="..."
                                                                 class="img-circle img-responsiv img_height_80"></a>
                                            </div>
                                            <div class="media-body">
                                                <h4 class="media-heading">超级管理员</h4>

                                                <p class="has_face"><?= $video_info->video_title ?></p>

                                                <div class="">
                                                    <span class="label label-default">Default</span>
                                                    <span class="label label-primary">Primary</span>
                                                    <span class="label label-success">Success</span>
                                                    <span class="label label-info">Info</span>
                                                </div>
                                                <div class="media">
                                                    <div class="media-middle">
                                                        <video src="<?= Url::to($videos . $video_info->video_path) ?>"
                                                               controls="controls"
                                                               class="col-xs-12">
                                                            <p>您的浏览器不支持html5，请更换浏览器</p>
                                                        </video>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <h5 class="col-xs-12">
                                                        <small><?= (int)(((time() - strtotime($video_info->video_date)) % (3600 * 24)) / (3600)); ?>
                                                            小时前
                                                        </small>
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer">
                                        <div class="row text-center">
                                            <a href="#" class="col-xs-3" role="button">收藏</a>
                                            <a href="#" class="col-xs-3" role="button">转发<span
                                                    class="badge"><?= $video_info->forward_count ?></span></a>
                                            <a href="#" class="col-xs-3" role="button">评论<span
                                                    class="badge"><?= $video_info->forward_count ?></span></a>
                                            <a href="#" class="col-xs-3 glyphicon glyphicon-thumbs-up"
                                               role="button"><span class="badge"><?= $video_info->praise_count ?></span></a>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="one_week">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <div class="media">
                                            <div class="media-left">
                                                <a href="#"><img src="<?= Url::to($heads . 'head (3).jpg') ?>" alt="..."
                                                                 class="img-circle img-responsiv img_height_80"></a>

                                                <div class="text-center"><a href="#" class="btn btn-warning"
                                                                            role="button">+关注</a></div>
                                            </div>
                                            <div class="media-body">
                                                <h4 class="media-heading">超级管理员</h4>

                                                <p>
                                                    哈哈哈哈哈哈哈哈哈哈超级管理员,超级管理员,哈哈哈哈哈哈哈哈哈哈超级管理员@哈哈哈哈哈哈哈哈哈哈超级管理员wa哈哈哈哈哈哈哈哈哈哈超级管理员</p>

                                                <div class="">
                                                    <span class="label label-default">Default</span>
                                                    <span class="label label-primary">Primary</span>
                                                    <span class="label label-success">Success</span>
                                                    <span class="label label-info">Info</span>
                                                </div>
                                                <div class="media">
                                                    <div class="media-middle">
                                                        <video
                                                            src="http://k.youku.com/player/getFlvPath/sid/5422793613396126b296a_01/st/mp4/fileid/0300200100542EEB91F37D14A45C8B4678D38F-9ED6-E726-1718-6BA379FC9745?K=3d00ab04f40f7f2a261e2726&hd=0&ymovie=1&myp=0&ts=776&ypp=2&ctype=12&ev=1&token=7403&oip=3663591661&ep=dyaWGE6EVcgB5iDWjj8bYX7gfXFeXP4J9h%2BHgdJjALshTOrK7EzYxuuzSYtDEogdd1EOYu%2F3rNiTaUhiYfk23W4QqkmqP%2Frh%2BfHr5ashtZMHb29Fe8rTsVSZRzDy"
                                                            controls="controls"
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
                                    <div class="panel-footer">
                                        <div class="row text-center">
                                            <a href="#" class="col-xs-3" role="button">收藏</a>
                                            <a href="#" class="col-xs-3" role="button">转发<span
                                                    class="badge">12562</span></a>
                                            <a href="#" class="col-xs-3" role="button">评论<span
                                                    class="badge">12562</span></a>
                                            <a href="#" class="col-xs-3 glyphicon glyphicon-thumbs-up"
                                               role="button"><span class="badge">12562</span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="one_month">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <div class="media">
                                            <div class="media-left">
                                                <a href="#"><img src="<?= Url::to($heads . 'head (2).jpg') ?>" alt="..."
                                                                 class="img-circle img-responsiv img_height_80"></a>

                                                <div class="text-center"><a href="#" class="btn btn-warning"
                                                                            role="button">+关注</a></div>
                                            </div>
                                            <div class="media-body">
                                                <h4 class="media-heading">超级管理员</h4>

                                                <p>
                                                    哈哈哈哈哈哈哈哈哈哈超级管理员,超级管理员,哈哈哈哈哈哈哈哈哈哈超级管理员@哈哈哈哈哈哈哈哈哈哈超级管理员wa哈哈哈哈哈哈哈哈哈哈超级管理员</p>

                                                <div class="">
                                                    <span class="label label-default">Default</span>
                                                    <span class="label label-primary">Primary</span>
                                                    <span class="label label-success">Success</span>
                                                    <span class="label label-info">Info</span>
                                                </div>
                                                <div class="media">
                                                    <div class="media-middle">
                                                        <video src="<?= Url::to($videos . 'a.mp4') ?>"
                                                               controls="controls"
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
                                    <div class="panel-footer">
                                        <div class="row text-center">
                                            <a href="#" class="col-xs-3" role="button">收藏</a>
                                            <a href="#" class="col-xs-3" role="button">转发<span
                                                    class="badge">12562</span></a>
                                            <a href="#" class="col-xs-3" role="button">评论<span
                                                    class="badge">12562</span></a>
                                            <a href="#" class="col-xs-3 glyphicon glyphicon-thumbs-up"
                                               role="button"><span class="badge">12562</span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                </div>

            </div>

        </div>
        <div class="col-xs-12 col-md-4">
            <?php if ($user): ?>
                <?php require(__DIR__ . '/fragment/user_info.php'); ?>
            <?php endif; ?>
            <?php require(__DIR__ . '/fragment/tag_cloud.php'); ?>
            <div class="hot-user">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h2 class="text-center text-danger">热门人物</h2>

                        <div class="col-xs-6 media text-center">
                            <div class="media-middle">
                                <a href="#"><img src="<?= Url::to($heads . 'head (5).jpg') ?>" alt=""
                                                 class="img-circle img-responsiv img-thumbnail"></a>
                            </div>
                            <div class="media-body text-center">
                                <a href="#" class="btn btn-warning" role="button">+关注<span
                                        class="badge">12562</span></a>
                            </div>
                        </div>
                        <div class="col-xs-6 media text-center">
                            <div class="media-middle">
                                <a href="#"><img src="<?= Url::to($heads . 'head (2).jpg') ?>" alt=""
                                                 class="img-circle img-responsiv img-thumbnail"></a>
                            </div>
                            <div class="media-body text-center">
                                <a href="#" class="btn btn-primary" role="button">已关注<span
                                        class="badge">12562</span></a>
                            </div>
                        </div>
                        <div class="col-xs-6 media text-center">
                            <div class="media-middle">
                                <a href="#"><img src="<?= Url::to($heads . 'head (5).jpg') ?>" alt=""
                                                 class="img-circle img-responsiv img-thumbnail"></a>
                            </div>
                            <div class="media-body text-center">
                                <a href="#" class="btn btn-warning" role="button">+关注<span
                                        class="badge">12562</span></a>
                            </div>
                        </div>
                        <div class="col-xs-6 media text-center">
                            <div class="media-middle">
                                <a href="#"><img src="<?= Url::to($heads . 'head (2).jpg') ?>" alt=""
                                                 class="img-circle img-responsiv img-thumbnail"></a>
                            </div>
                            <div class="media-body text-center">
                                <a href="#" class="btn btn-primary" role="button">已关注<span
                                        class="badge">12562</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
