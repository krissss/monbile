<?php
/**
 * 筛选榜单
 */
/* @var $this \yii\web\View */
/* @var $tops_info :: render */

use yii\helpers\Url;

$heads = Url::to('/heads/');
$videos = Url::to('/videos/');

$this->title = '筛选榜单';
?>
<div class="user-default-videos">
    <?php if(count($tops_info)>0):?>
    <div class="row">
        <div class="col-xs-12 col-md-12">
            <div class="alert alert-info" role="alert">
                管理员可以点击右侧按钮取消视频展示的权限（如果视频存在不合法的情况）,当确保有前10名可以展示时后面的视频可以不用审核，直接点击完成审核。
            </div>
        </div>
        <div class="col-xs-12 col-md-12">
            <button class="btn btn-primary pull-right end_video_pass" data-top-type="<?=$tops_info[0]->top_type;?>" data-top-date="<?=$tops_info[0]->top_date;?>">完成审核</button>
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
                <?php foreach ($tops_info as $top_info): ?>
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
        </div>
    </div>
    <?php else: ?>
        <div class="alert alert-danger" role="alert">没有相关信息，<strong><a href="<?=Url::to(['/superAdmin/default/index'])?>">点我返回</a></strong></div>
    <?php endif; ?>
</div>