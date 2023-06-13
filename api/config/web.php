<?php

$config = [
    'homeUrl' => Yii::getAlias('@apiUrl'),
    'controllerNamespace' => 'api\controllers',
    'defaultRoute' => 'site/index',
    'bootstrap' => ['maintenance'],
    'modules' => [
        'v1' => api\modules\v1\Module::class,
        'cabinet' => api\modules\cabinet\Module::class,
        'supervisor' => api\modules\supervisor\Module::class,
        'member' => api\modules\member\Module::class,
        'intern' => api\modules\intern\Module::class,
        'mentor' => api\modules\mentor\Module::class,
        'user' => [
            'class' => common\modules\user\Module::class,
            'shouldBeActivated' => false,
            'enableLoginByPass' => false,
        ],
    ],
    'components' => [
        'errorHandler' => [
            'errorAction' => 'site/error'
        ],
        'maintenance' => [
            'class' => common\components\maintenance\Maintenance::class,
            'enabled' => function ($app) {
                if (env('APP_MAINTENANCE') === '1') {
                    return true;
                }
                return $app->keyStorage->get('backend.maintenance') === 'enabled';
            }
        ],
        'request' => [
            'enableCookieValidation' => false,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser'
            ]
        ],
        'user' => [
            'class' => yii\web\User::class,
            'identityClass' => common\models\User::class,
            'loginUrl' => ['/user/sign-in/login'],
            'enableAutoLogin' => true,
            'as afterLogin' => common\behaviors\LoginTimestampBehavior::class
        ],
        'jwt' => [
            'class' => \sizeg\jwt\Jwt::class,
            'key'   => env('JWT_SECRET'),
            'jwtValidationData' => \common\components\jwt\JwtValidationData::class,
        ]
    ]
];

return $config;
