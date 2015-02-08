<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',//原本的
        'css/style.css',//自己写的
        'css/jquery-sinaEmotion-2.1.0.css',//新浪表情
        'css/jquery-tag-this.css',//写标签
    ];
    public $js = [
        //'js/jquery.cookie.js',
        'js/charCount.js',//统计字数
        'js/jquery-sinaEmotion-2.1.0.js',//新浪表情
        'js/jquery.tagcanvas.js',//标签云
        'js/jquery-tag-this.js',//写标签
        /* 上传头像 */
        'js/fullAvatarEditor.js',
        'js/swfobject.js',
        /* 总方法调用 */
        'js/monbile.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
