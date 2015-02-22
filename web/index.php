<?php

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
// 开发模式
defined('YII_ENV') or define('YII_ENV', 'dev');
// 产品模式
//defined('YII_ENV') or define('YII_ENV', 'prod');

require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

$config = require(__DIR__ . '/../config/web.php');

$application = new yii\web\Application($config);
$application->language = isset($_COOKIE['language']) ? htmlspecialchars($_COOKIE['language']) : 'zh-CN';
$application->run();
