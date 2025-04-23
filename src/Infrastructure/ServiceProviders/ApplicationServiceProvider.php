<?php

namespace App\Infrastructure\ServiceProviders;

use App\ExternalApi\ApiClient\ApiHttpClient;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use League\Container\Argument\Literal\StringArgument;
use League\Container\ServiceProvider\AbstractServiceProvider;

class ApplicationServiceProvider extends AbstractServiceProvider
{
    public function provides(string $id): bool
    {
        $services = [
            ClientInterface::class,
            ApiHttpClient::class,
        ];

        return in_array($id, $services);
    }

    public function register(): void
    {
        $container = $this->getContainer();

        $container
            ->add(ClientInterface::class, Client::class);

        $container
            ->add(ApiHttpClient::class)
            ->addArguments(
                [
                    ClientInterface::class,
                    new StringArgument($_ENV['BASE_API_URL']),
                    new StringArgument($_ENV['ADMIN_TOKEN']),
                ]
            );
    }
}
