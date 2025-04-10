<?php

namespace App\ExternalApi\ApiClient;

use GuzzleHttp\ClientInterface;

readonly class ApiHttpClient
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

    public function post(string $route, array $body): void
    {
        $body['format'] = 'json';

        $url = $this->basicUrl . $route;

        $parameters = [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->authToken,
            ],
            'form_params' => $body,
        ];

        $this->client->request('POST', $url, $parameters);
    }
}
