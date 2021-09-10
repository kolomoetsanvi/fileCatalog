<?php

use yii\db\Connection;
use yii\rbac\DbManager;

return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'db' => [
            'class' => Connection::class,
            'dsn' => 'mysql:host=0.0.0.0;dbname=file_catalog_db;port=33061',
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8',
        ],
        'authManager' => [
            'class' => DbManager::class,
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];
