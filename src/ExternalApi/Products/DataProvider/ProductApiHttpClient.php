<?php

namespace App\ExternalApi\Products\DataProvider;

use GuzzleHttp\ClientInterface;

readonly class ProductApiHttpClient implements ProductApiHttpClientInterface
{
    public function __construct(
        private ClientInterface $client,
        private string $basicUrl,
        private string $authToken,
    ) {
    }

    public function get(string $route, array $parameters): array
    {
        $url = $this->basicUrl . $route;

        $parameters = [
            ...$parameters,
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->authToken,
                ]
            ]
        ];

        $this->client->request('GET', $route, $parameters);
    }
}