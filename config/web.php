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
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'layout' => 'main',
    'components' => [
        // Session
        'session' => [
            'class' => '\yii\web\Session',
            'name' => '$$YII2$$LEARNING@@SELFSTUDY$$',
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'yEuMvN5xJLvmmxwBFr6WPHvC-RQ_j4Cl',
        ],

        // Using MemCache
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'useMemcached'=> true,
            'class' => 'yii\caching\MemCache',
            'servers' => [
                [
                    'host' => 'localhost',
                    'port' => 11211,
                    'weight' => 100,
                ],
            ],
        ],

        // User Identity
        'user' => [
            'identityClass' => 'app\models\User',
            // enable cookie-based authentication
            'enableAutoLogin' => true,
        ],

        // Handler Error
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        // Using Twig template
        'view' => [
            'class' => 'yii\web\View',
            'renderers' => [
                'twig' => [
                    'class' => 'yii\twig\ViewRenderer',
                    //'cachePath' => '@runtime/Twig/cache', // No use Twig tempplate caching
                    'options' => [
                        'auto_reload' => true,
                    ],
                    'globals' => ['html' => '\yii\helpers\Html'],
                    'uses' => ['yii\bootstrap'],
                    'functions' => array(
                        'yii_t' => 'Yii::t',
                    ),
                    'filters' => [
                        'jsonDecode' => '\yii\helpers\Json::decode',
                        'jsonEncode' => '\yii\helpers\Json::encode',
                    ],
                ],
            ],
        ],
        
        // Url Manager
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<controller>/<action>/<id:\w+>' => '<controller>/<action>',
            ],
        ],
        'assetManager' => [
            'forceCopy' => true
            //'bundles' => require(__DIR__ . '/compressed_asset.php'),
        ],

        // Mailer
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],

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

        // Database
        'db' => require(__DIR__ . '/db.php'),
    ],

    // Required authenticated users(login) when using the site
    'as access' => [
        'class' => 'yii\filters\AccessControl',
        'rules' => [
            [
                'actions' => ['login', 'error'],
                'allow' => true,
            ],
            [
                'allow' => true,
                'roles' => ['@'],
            ],
        ]
    ],
    'params' => $params,
    'defaultRoute' => 'site/index',
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
