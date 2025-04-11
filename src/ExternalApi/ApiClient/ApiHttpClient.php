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

        $response = $this->client->request('GET', $url, $parameters);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function post(string $route, array $body): array
    {
        $body['format'] = 'json';

        $url = $this->basicUrl . $route;

        $parameters = [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->authToken,
            ],
            'form_params' => $body,
        ];

        $response = $this->client->request('POST', $url, $parameters);

        return json_decode($response->getBody()->getContents(), true);
    }
}
