<?php
/**
 * 热门标签
 * site/index
 * 在包含页面需定义以下变量
 */
/* @var $tags_hot :: render */
?>

<div class="hot-tag">
    <div class="panel panel-default">
        <div class="panel-body">
            <h2 class="text-center text-danger">热门标签</h2>
            <canvas width="328" height="328" id="myCanvas">
                <p>你的浏览器不支持html5，请更换浏览器</p>
                <ul>
                    <?php foreach ($tags_hot as $tag_info): ?>
                        <li><a href="javascript:void(0);"><?=$tag_info->tag_name;?></a></li>
                    <?php endforeach; ?>
            </canvas>
        </div>
    </div>
</div>