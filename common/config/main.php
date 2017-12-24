<?php
return [
    'language'=>'zh-CN',//中午
    'timeZone'=>'PRC',//时区
    'defaultRoute'=>'brand/index',//默认路由
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];
