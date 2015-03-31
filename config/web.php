<?php

$params = require(__DIR__ . '/params.php');
//var_dump(YII_ENV_DEV);
$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'gii'],
    'components' => [
        'urlManager' => [
        'enablePrettyUrl' => true,
        //'enableStrictParsing' => true,
        'showScriptName' => false,
        'rules' => [
          ['class' => 'yii\rest\UrlRule', 'pluralize' => false, 'controller' => 'country'],
      ],
  ],
        'authManager' => [
        'class' => 'yii\rbac\PhpManager',
        ],

        'request' => [
            
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'Mpf3oUJirH5oL-wFAfHFEDciN7XCS0V3',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
       ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,

            //'enableSession' => false,
            'loginUrl' => null,
        ],

        'session'=>array(
            // enable cookie-based authentication
            // 'allowAutoLogin'=>true,
            'timeout'=>10,
        ),


        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning', 'info'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),



        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'google' => [
                    //'class' => 'yii\authclient\clients\GoogleOpenId'
                    'class' => 'yii\authclient\clients\GoogleOAuth',
                    /*'clientId' => 'google_client_id',
                    'clientSecret' => 'google_client_secret',*/
                    'clientId' => '583693791244-plsekueuhk748bmcfioj9g7q8l9djccu.apps.googleusercontent.com',
                    'clientSecret' => 'ohjteStfR2wx3IkaNMsrFDVX',
                    'scope' => 'https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/drive',
                    'returnUrl' => 'http://kilobeat.com',
                    ],
                'facebook' => [
                    'class' => 'yii\authclient\clients\Facebook',
                    'clientId' => 'facebook_client_id',
                    'clientSecret' => 'facebook_client_secret',
                    ],
                // etc.
            ],
        ]

        

    ],
    'params' => $params,
];

//if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
//}

return $config;
