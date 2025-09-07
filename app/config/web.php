<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'zk9bQBbaGvEne6XubSsEF7xU6NhzIjRa',
        ],
        'authManager' => [
            'class' => yii\rbac\DbManager::class, // таблицы RBAC в БД
        ],
        'formatter' => [
            'class' => yii\i18n\Formatter::class,
            'decimalSeparator' => '.',
            'thousandSeparator' => ' ',
            'currencyCode' => 'RUB',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false, // можно включить true, если хочешь, чтобы работали только правила
            'rules' => [

                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['api/order'], // контроллер: controllers/api/OrderController
                    'pluralize' => false,          // чтобы путь был /api/order (а не /api/orders)
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['api/product'], // controllers/api/ProductController
                    'pluralize' => false,
                ],

                // CRUD для OrderController
                'order/<id:\d+>/view'   => 'order/view',
                'order/<id:\d+>/update' => 'order/update',
                'order/create'          => 'order/create',
                'order/index'           => 'order/index',
                'order'                 => 'order/index',

                // CRUD для ProductController
                'product/<id:\d+>/view'   => 'product/view',
                'product/<id:\d+>/update' => 'product/update',
                'product/create'          => 'product/create',
                'product/index'           => 'product/index',
                'product/sync'            => 'product/sync',
                'product'                 => 'product/index',

                // CRUD для UserController
                'user/<id:\d+>/view'   => 'user/view',
                'user/<id:\d+>/update' => 'user/update',
                'user/create'          => 'user/create',
                'user/index'           => 'user/index',
                'user'                 => 'user/index',
            ],
        ],
    ],
    'container' => [
        'singletons' => [
            app\components\services\ParserInterface::class => app\components\services\DummyJsonSyncParser::class,
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['*'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['*'],
    ];
}

return $config;
