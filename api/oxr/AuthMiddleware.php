<?php

declare(strict_types=1);

namespace app\api\oxr;

use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\RequestInterface;

final class AuthMiddleware
{
    private function __construct()
    {
    }

    public static function create(string $appId): callable
    {
        return Middleware::mapRequest(function (RequestInterface $request) use ($appId) {
            return $request->withUri(Uri::withQueryValue($request->getUri(), 'app_id', $appId));
        });
    }
}
