<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'queue'],
    'controllerNamespace' => 'app\commands',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@tests' => '@app/tests',
    ],
    'components' => [
        'queue' => [
            'class' => \yii\queue\db\Queue::class,
            'as log' => \yii\queue\LogBehavior::class,
            'as behavior' => \app\components\BehaviorErrorQueue::class,
            'db' => 'db', // компонент подключения к БД
            'tableName' => '{{%queue}}', // Имя таблицы
            'channel' => 'default', // Queue channel key
            'mutex' => \yii\mutex\MysqlMutex::class, // Mutex used to sync queries
        ],
        'mailer' => [
            'class' => \yii\swiftmailer\Mailer::class,
            'viewPath' => '@app/mail',
            'htmlLayout' => 'layouts/main-html',
            'messageConfig' => [
                'charset' => 'UTF-8',
                'from' => ['manager-admin@site.com' => 'From Manager Post Queue'],
            ],
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'zt.evakuator',
                'password' => 'zxc123zxc',
                'port' => '587',
                'encryption' => 'tls',
                'streamOptions' => [ 'ssl' => [ 'allow_self_signed' => true, 'verify_peer' => false, 'verify_peer_name' => false, ], ]
            ],
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'scriptUrl' => '',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
    ],
    'params' => $params,
    /*
    'controllerMap' => [
        'fixture' => [ // Fixture generation command line.
            'class' => 'yii\faker\FixtureController',
        ],
    ],
    */
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
