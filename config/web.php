<?php

$params = require(__DIR__ . '/params.php');

// for debug
function dump($var = '',$exit = true)
{
    echo "<pre>";
    print_r($var);
    echo "</pre>";
    if($exit)
    exit();
}

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [

        // Cache
        'cache' => [
           'class' => 'yii\caching\FileCache',
        ],
        
        // UserIdentity
        'user' => [
            'identityClass' => 'app\models\Users',
            'enableAutoLogin' => true,
        ],

        // Database
        'db' => require(__DIR__ . '/db.php'),

        // Logging
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        // UrlManager
        'urlManager' => [
            'class' => 'yii\web\UrlManager',

            // Disable index.php
            'showScriptName' => false,

            // Disable r=routes
            'enablePrettyUrl' => true,
            'rules' => [
                '<controller>/<action>/<id:\w+>' => '<controller>/<action>',
            ],
        ],        
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
