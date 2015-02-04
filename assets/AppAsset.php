<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/style.css',
        'css/jquery-sinaEmotion-2.1.0.css',
        'css/jquery-tag-this.css',
    ];
    public $js = [
        //'js/jquery.cookie.js',
        'js/charCount.js',
        'js/jquery-sinaEmotion-2.1.0.js',
        'js/jquery.tagcanvas.js',
        'js/jquery-tag-this.js',

        'js/monbile.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
