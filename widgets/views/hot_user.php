<?php
/* @var $users_hot */
/* @var $relations_array */
/* @var $session_user */
?>
<div class="hot-tag">
    <div class="panel panel-default">
        <div class="panel-body">
            <h2 class="text-center text-danger">风云人物</h2>
            <?php $fans_number = 0;//作用：用于判断当下一个用户的粉丝数和上一个一样，但已经超过10位，此时还是会将该用户列出来?>
            <?php for ($i=0 ; $i<count($users_hot) && ($i<10 || $fans_number==$users_hot[$i]['relationsBack']); $i++): ?>
            <?php $user_relation = $users_hot[$i]['user']; ?>
                <?=\app\widgets\UserRelationInfoWidget::widget(['user_relation'=>$user_relation,'is_hot_user'=>true])?>
            <?php endfor; ?>
        </div>
    </div>
</div>