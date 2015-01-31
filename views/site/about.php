<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        This is the About page. You may modify the following file to customize its content:
    </p>
    <!-- Creative Commons Licence (by-nc-nd). See worditout.com for details -->
    <div style='width:auto;height:auto;'><!-- You may use this wrapping div to restrict the height or width -->
        <script type='text/javascript' charset='utf-8'  src='http://worditout.com/word-cloud/675500/private/ab7557a33f7f8a8997aeaa7caf82a9e3/embed.js'></script>
        <noscript><p style='text-align:center;font-size:xx-small;overflow:auto;height:100%;'><a href='http://worditout.com/word-cloud/675500/private/ab7557a33f7f8a8997aeaa7caf82a9e3' title='Click to go to this word&nbsp;cloud on WordItOut.com'>&quot;test&quot;</a><br />Click on the link above to see this word&nbsp;cloud at <a href='http://worditout.com' title='Transform your text into word&nbsp;clouds!'>WordItOut</a>. You may also view it on this website if you enable JavaScript (see your web browser settings).</p></noscript>
    </div>
    <code><?= __FILE__ ?></code>
</div>
