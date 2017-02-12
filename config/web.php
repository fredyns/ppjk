<?php
$params = require(__DIR__.'/params.php');
$confidential = require(__DIR__.'/confidential.php');

$config = [
    'id' => $params['app']['id'],
    'name' => $params['app']['name'],
    'language' => 'id-ID',
    'timeZone' => 'Asia/Jakarta',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'uLejxRgQhpq4Nx8mDPddJ6alomJY34yk',
        ],
        'session' => [
            'class' => 'yii\web\DbSession',
            'sessionTable' => 'yii_session',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'response' => [
            'formatters' => [
                \yii\web\Response::FORMAT_JSON => [
                    'class' => 'yii\web\JsonResponseFormatter',
                    'prettyPrint' => TRUE,
                    'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
                ],
            ],
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'formatter' => [
            'locale' => 'id_ID',
            'thousandSeparator' => '.',
            'decimalSeparator' => ',',
            'currencyCode' => 'IDR',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => $confidential['mailer'],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__.'/db.php'),
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@dektrium/user/views' => '@app/views/user'
                ],
            ],
        ],
    ],
    'modules' => [
        'user' => [
            'class' => 'dektrium\user\Module',
            'enableRegistration' => true,
            'enableUnconfirmedLogin' => true,
            'admins' => $confidential['admins'],
            'modelMap' => [
                'User' => 'app\models\User',
                'Profile' => 'app\models\Profile',
            ],
            'controllerMap' => require(__DIR__.'/module/user-controllerMap.php'),
        ],
        'gridview' => [
            'class' => '\kartik\grid\Module'
        ],
    ],
    'controllerMap' => [
        'file' => 'mdm\\upload\\FileController', // use to show or download file
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'generators' => [
            'giiant-model' => [
                'class' => 'fredyns\suite\giiant\model\Generator',
            ],
            'giiant-crud' => [
                'class' => 'fredyns\suite\giiant\crud\Generator',
            ],
        ],
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
