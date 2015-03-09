<?php
/**
 * 推荐关注的同校好友
 */
/* @var $sameSchoolUser :: render */
?>
<div class="row">
    <?php foreach($sameSchoolUser as $user_relation): ?>
        <div class="col-xs-12 col-md-6">
            <?php require(__DIR__ . './user_relation_info.php'); ?>
        </div>
    <?php endforeach; ?>
</div>
