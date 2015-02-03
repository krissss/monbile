<?php
/**
 * Created by PhpStorm.
 * User: kriss
 * Date: 2015/2/2
 * Time: 18:58
 */
?>
<!--class   collapse   -->
<div class="panel panel-default " id="send_video">
    <div class="panel-body">
        <form role="form">
            <div class="form-group" id="video_send_div">
                <label for="exampleInputPassword1" class="counter_label">说点啥</label>
                <textarea id="video_message" class="form-control" rows="3">[呵呵]三杀 四杀 五杀 还有谁</textarea>
                <input type="hidden" name="tag" id="tag">
                <input type="hidden" name="video_game" id="classify">
            </div>
            <button type="button" class="btn btn-default" id="add_face">添加表情</button>
            <button type="button" class="btn btn-default" id="add_tag">标签</button>
            <div class="dropdown div_inline">
                <button class="btn btn-default dropdown-toggle" type="button" id="change_classify" data-toggle="dropdown" aria-expanded="true">
                    类型 <span class="caret"></span>
                </button>
                <ul id="change_classify_ul" class="dropdown-menu" role="menu" aria-labelledby="change_classify">
                    <li role="presentation" data-gid="1"><a role="menuitem" tabindex="-1" href="javascript:void(0);">英雄联盟</a></li>
                    <li role="presentation" data-gid="2"><a role="menuitem" tabindex="-1" href="javascript:void(0);">Dota</a></li>
                    <li role="presentation" data-gid="3"><a role="menuitem" tabindex="-1" href="javascript:void(0);">炉石传说</a></li>
                    <li role="presentation" data-gid="4"><a role="menuitem" tabindex="-1" href="javascript:void(0);">剑灵</a></li>
                </ul>
            </div>
            <button type="button" class="btn btn-default">添加视频</button>
            <button type="button" class="btn btn-default pull-right" id="show_face">发布</button>
        </form>
    </div>
</div>
