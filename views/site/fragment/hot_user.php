<?php
/**
 * 热门标签
 * site/index
 * 在包含页面需定义以下变量
 */
/* @var $users_hot :: session */
/* @var $relations_array :: render */
/* @var $session_user :: session */
?>
<div class="hot-tag">
    <div class="panel panel-default">
        <div class="panel-body">
            <h2 class="text-center text-danger">风云人物</h2>
            <?php $fans_number = 0;//作用：用于判断当下一个用户的粉丝数和上一个一样，但已经超过10位，此时还是会将该用户列出来?>
            <?php for ($i=0 ; $i<count($users_hot) && ($i<10 || $fans_number==$users_hot[$i]['relationsBack']); $i++): ?>
            <?php $user_relation = $users_hot[$i]['user']; ?>
                <?php $is_hot_user = true;?>
                <?php require(__DIR__ . '/user_relation_info.php'); ?>
            <?php endfor; ?>
        </div>
    </div>
</div>