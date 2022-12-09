<?php

declare(strict_types=1);

namespace app\config;

use Dotenv\Repository\Adapter\EnvConstAdapter;
use Dotenv\Repository\RepositoryBuilder;
use Dotenv\Repository\RepositoryInterface;

class Env
{
    private static RepositoryInterface $repository;

    public static function getRepository(): RepositoryInterface
    {
        if (!isset(static::$repository)) {
            $builder = RepositoryBuilder::createWithNoAdapters()
                ->addAdapter(EnvConstAdapter::class);

            static::$repository = $builder->immutable()->make();
        }

        return static::$repository;
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        $value = static::getRepository()->get($key);

        if (is_null($value)) {
            return $default instanceof \Closure ? $default() : $default;
        }

        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return true;
            case 'false':
            case '(false)':
                return false;
            case 'empty':
            case '(empty)':
                return '';
            case 'null':
            case '(null)':
                return null;
        }

        if (preg_match('/\A([\'"])(.*)\1\z/', $value, $matches)) {
            return $matches[2];
        }

        return $value;
    }
}
