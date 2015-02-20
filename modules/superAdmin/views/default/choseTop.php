<?php
/**
 * 筛选top10
 */
/* @var $this \yii\web\View */
/* @var $videos_info :: render */

use yii\helpers\Url;

$heads = Url::to('/heads/');
$videos = Url::to('/videos/');

$this->title = '筛选top10';
?>
<div class="user-default-videos">
    <div class="row">
        <div class="col-xs-12 col-md-12">
            <div class="alert alert-info" role="alert">
                管理员可以点击右侧按钮取消视频展示的权限（如果视频存在不合法的情况）
            </div>
        </div>
        <div class="col-xs-12 col-md-12">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>发布者</th>
                        <th>视频</th>
                        <th>赞</th>
                        <th>评论</th>
                        <th>标题</th>
                        <th>标签</th>
                        <th>日期</th>
                        <th>审核</th>
                    </tr>
                </thead>
                <tbody>
                <?php $number = 1;?>
                <?php foreach ($videos_info as $top_info): ?>
                    <?php $video_info = $top_info->video;?>
                    <tr>
                        <td><?=$number++;?></td>
                        <td>
                            <img src="<?= Url::to($heads . $video_info->user->head) ?>" alt="<?= $video_info->user->nickname ?>" title="<?= $video_info->user->nickname ?>" class="img-circle img-responsiv img_height_80">
                            <p class="text-center"><?=$video_info->user->nickname?></p>
                        </td>
                        <td>
                            <object width="320" height="200">
                                <param name="movie" value="flvplayer.swf">
                                <param name="quality" value="high">
                                <param name="allowFullScreen" value="true">
                                <param name="FlashVars" value="vcastr_file=<?= Url::to($videos . $video_info->video_path) ?>&LogoText=www.monbile.cn&BufferTime=3&IsAutoPlay=0">
                                <embed src="flvplayer.swf" allowfullscreen="true" flashvars="vcastr_file=<?= Url::to($videos . $video_info->video_path) ?>&LogoText=www.monbile.cn&BufferTime=3&IsAutoPlay=0" quality="high" width="100%" height="200"></embed>
                            </object>
                        </td>
                        <td><?=$video_info->praise_count?></td>
                        <td><?=$video_info->comment_count?></td>
                        <td><p class="has_face"><?= $video_info->video_title ?></p></td>
                        <td>
                            <div class="has_tag">
                                <?php foreach ($video_info->tagRelations as $tagRelation_info): ?>
                                    <span class="tag tag-color-<?= rand(0, 6) ?>"><?= $tagRelation_info->tag->tag_name ?></span>
                                <?php endforeach; ?>
                            </div>
                        </td>
                        <td><?=$video_info->video_date?></td>
                        <td><button class="btn <?=$top_info->top_state==1?'btn-primary':'btn-danger'?> pass_video" data-top-id="<?=$top_info->tid?>"><?=$top_info->top_state==1?'通过':'未通过'?></button></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <a href="<?=Url::to(['/superAdmin/default/index'])?>" class="btn btn-primary pull-right">完成审核</a>
        </div>
    </div>
</div>