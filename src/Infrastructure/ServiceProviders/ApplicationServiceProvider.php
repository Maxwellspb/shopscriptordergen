<?php

namespace App\Infrastructure\ServiceProviders;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use League\Container\ServiceProvider\AbstractServiceProvider;

class ApplicationServiceProvider extends AbstractServiceProvider
{
    public function provides(string $id): bool
    {
        $services = [
            ClientInterface::class,
        ];

        return in_array($id, $services);
    }

    public function register(): void
    {
        $container = $this->getContainer();

        $container
            ->add(ClientInterface::class, Client::class);
    }
}