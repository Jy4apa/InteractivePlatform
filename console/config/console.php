<?php
return [
    'id' => 'console',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'console\controllers',
    'controllerMap' => [
        'command-bus' => [
            'class' => trntv\bus\console\BackgroundBusController::class,
        ],
        'message' => [
            'class' => console\controllers\ExtendedMessageController::class
        ],
        'migrate' => [
            'class' => yii\console\controllers\MigrateController::class,
            'migrationPath' => '@common/migrations/db',
            'migrationTable' => '{{%system_db_migration}}'
        ],
        'rbac-migrate' => [
            'class' => console\controllers\RbacMigrateController::class,
            'migrationPath' => '@common/migrations/rbac/',
            'migrationTable' => '{{%system_rbac_migration}}',
            'templateFile' => '@common/rbac/views/migration.php'
        ],
    ],
    'components' => [
        'redis' => [
            'class' => yii\redis\Connection::class,
            'database' => env('REDIS_DATABASE'),
            'hostname' => env('REDIS_HOST'),
            'port' => env('REDIS_PORT'),
            'password' => env('REDIS_PASSWORD'),
            'retries' => 1,
        ],
        'queue' => [
            'class' => common\base\OpenQueue::class,
            'as log' => \yii\queue\LogBehavior::class,
            'redis' => 'redis', // Redis connection component or its config
            'channel' => 'queue', // Queue channel key
        ],
        'jwt' => [
            'class' => \sizeg\jwt\Jwt::class,
            'key'   => env('JWT_SECRET'),
            'jwtValidationData' => \common\components\jwt\JwtValidationData::class,
        ],
        'user' => [
            'class' => yii\web\User::class,
            'identityClass' => common\models\User::class,
            'enableSession' => false,
            'enableAutoLogin' => false,
        ],
    ]
];
