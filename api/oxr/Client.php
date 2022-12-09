<?php

declare(strict_types=1);

namespace app\api\oxr;

use yii\helpers\Json;

class Client
{
    public function __construct(private readonly \GuzzleHttp\Client $http)
    {
    }

    public function latest(string $base, string $symbols = null, bool $show_alternative = false): RateCollection
    {
        $query = [
            'base' => $base,
            'prettyprint' => false,
        ];
        if (isset($symbols)) {
            $query['symbols'] = $symbols;
        }
        if (isset($show_alternative)) {
            $query['show_alternative'] = $show_alternative;
        }
        $response = $this->http->get('/api/latest.json', [
            'query' => $query,
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);
        $json = $response->getBody()->getContents();
        $data = Json::decode($json);

        return new RateCollection($data['rates'], $data['timestamp']);
    }
}
