<?php
/* @var $this \yii\web\View */

$this->registerJsFile('js/fullAvatarEditor.js');
$this->registerJsFile('js/swfobject.js');

$this->title = '修改头像';
?>
<div class="user-default-changehead">
<div style="width:100%;margin: 0 auto;text-align:center">
    <h1 style="text-align:center">用户头像上传</h1>

    <div>
        <p id="swfContainer">
            本组件需要安装Flash Player后才可使用，请从<a href="http://www.adobe.com/go/getflashplayer">这里</a>下载安装。
        </p>
    </div>
</div>

</div>