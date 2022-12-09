<?php

declare(strict_types=1);

namespace app\bootstrap;

use app\api\oxr\AuthMiddleware;
use app\api\oxr\Client;
use GuzzleHttp\HandlerStack;
use yii\base\BootstrapInterface;

class SetUp implements BootstrapInterface
{
    public function bootstrap($app): void
    {
        $container = \Yii::$container;

        $container->set(Client::class, function () {
            $handler = HandlerStack::create();
            $handler->push(AuthMiddleware::create(env('OXR_APP_ID')));
            $http = new \GuzzleHttp\Client([
                'handler' => $handler,
                'base_uri' => env('OXR_DOMAIN'),
            ]);

            return new Client($http);
        });
    }
}
