<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2mobile',
    'tablePrefix' => 'mb_',
    'username' => 'root',
    'password' => 'root',
    'charset' => 'utf8',
    //添加数据库表缓存
    'enableSchemaCache' => true,
    'schemaCacheDuration' => 3600,
    'schemaCache' => 'cache',
];
