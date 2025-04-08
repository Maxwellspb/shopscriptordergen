<?php

namespace App\ExternalApi\ApiClient;

use App\ExternalApi\Products\DataProvider\ProductApiHttpClientInterface;
use GuzzleHttp\ClientInterface;

readonly class ShopApiHttpClient implements ProductApiHttpClientInterface
{
    public function __construct(
        private ClientInterface $client,
        private string $basicUrl,
        private string $authToken
    ) {
    }

    public function get(string $route, array $parameters): array
    {
        $parameters['format'] = 'json';

        $url = $this->basicUrl . $route;

        $parameters = [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->authToken,
            ],
            'query' => $parameters,
        ];

        $result = $this->client->request('GET', $url, $parameters);

        return json_decode($result->getBody()->getContents(), true);
    }
}
