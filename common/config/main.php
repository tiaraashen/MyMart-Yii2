<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'MyComponent' => [
            'class' => 'common\components\MyComponent',
            'on event_trigger' => ['common\components\MyComponent','addToStatistic']
        ]
    ],
];
