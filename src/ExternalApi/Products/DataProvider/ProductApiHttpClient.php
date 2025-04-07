<?php

namespace App\ExternalApi\Products\DataProvider;

use GuzzleHttp\ClientInterface;

readonly class ProductApiHttpClient implements ProductApiHttpClientInterface
{
    public function __construct(
        private ClientInterface $client,
        private string $basicUrl,
    ) {
    }

    public function get(string $route, array $parameters): array
    {
        $parameters['format'] = 'json';

        $url = $this->basicUrl . $route;

        $parameters = [
            'headers' => [
                'Authorization' => 'Bearer ' . $parameters['authToken'],
            ],
            'query' => $parameters,
        ];

        $result = $this->client->request('GET', $url, $parameters);

        return json_decode($result->getBody()->getContents(), true);
    }
}