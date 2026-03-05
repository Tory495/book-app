<?php

$params = array_merge(
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],
        'sms' => [
            'class' => \common\components\SmsPilot::class,
            'apiKey' => $params['smsComponentApiKey'] ?? '',
            'sender' => $params['smsComponentSender'] ?? 'INFORM',
        ],
        'authManager' => [
            'class' => \yii\rbac\DbManager::class,
        ],
    ],
    'container' => [
        'definitions' => [
            \common\contracts\SubscriptionRepoInterface::class => \common\repo\mysql\subscription\SubscriptionRepo::class,
            \common\contracts\AuthorRepoInterface::class => \common\repo\mysql\author\AuthorRepo::class,
            \common\contracts\ImageStorageServiceInterface::class => \common\services\book\BookImageStorageService::class,
            \common\contracts\SubscriptionServiceInterface::class => \common\services\subscription\SubscriptionService::class,
        ],
    ],
];
