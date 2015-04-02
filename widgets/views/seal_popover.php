<?php
/* @var $session_user */

use yii\helpers\Html;
?>
<div id="popoverContent" class="hidden">
    <div class="row">
        <?php if($session_user):?>
            <a href="javascript:void(0);" class="seal_button" data-seal="seal_1"><?=Html::img("./imgs/seal/".$session_user->uid."/seal_1.png",['class'=>'col-xs-6','title'=>'便便'])?></a>
            <a href="javascript:void(0);" class="seal_button" data-seal="seal_2"><?=Html::img("./imgs/seal/".$session_user->uid."/seal_2.png",['class'=>'col-xs-6','title'=>'火火火'])?></a>
            <a href="javascript:void(0);" class="seal_button" data-seal="seal_3"><?=Html::img("./imgs/seal/".$session_user->uid."/seal_3.png",['class'=>'col-xs-6','title'=>'水水水'])?></a>
            <a href="javascript:void(0);" class="seal_button" data-seal="seal_4"><?=Html::img("./imgs/seal/".$session_user->uid."/seal_4.png",['class'=>'col-xs-6','title'=>'王者风范'])?></a>
        <?php else:?>
            <a href="javascript:void(0);" class="seal_button"><?=Html::img("./imgs/seal/seal_1.png",['class'=>'col-xs-6','title'=>'便便'])?></a>
            <a href="javascript:void(0);" class="seal_button"><?=Html::img("./imgs/seal/seal_2.png",['class'=>'col-xs-6','title'=>'火火火'])?></a>
            <a href="javascript:void(0);" class="seal_button"><?=Html::img("./imgs/seal/seal_3.png",['class'=>'col-xs-6','title'=>'水水水'])?></a>
            <a href="javascript:void(0);" class="seal_button"><?=Html::img("./imgs/seal/seal_4.png",['class'=>'col-xs-6','title'=>'王者风范'])?></a>
        <?php endif; ?>
    </div>
</div>