<?php
/* @var $tags_hot */

use \yii\helpers\Url;
?>

<div class="hot-tag">
    <div class="panel panel-default">
        <div class="panel-body">
            <h2 class="text-center text-danger">热门标签</h2>
            <canvas width="328" height="328" id="myCanvas">
                <p>你的浏览器不支持html5，请更换浏览器</p>
                <ul>
                    <?php foreach ($tags_hot as $tag_info): ?>
                        <li><a href="<?=Url::to(['/site/search','id'=>$tag_info->hid])?>" title="点我可以搜索哦"><?=$tag_info->hero_name_cn;?></a></li>
                    <?php endforeach; ?>
            </canvas>
        </div>
    </div>
</div>