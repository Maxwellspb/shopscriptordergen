<?php

namespace App\Infrastructure\Providers;

use App\ExternalApi\ServiceProvider\ProductApiServiceProvider;
use App\Infrastructure\CommandHandler\ServiceProvider\CommandHandlingServiceProvider;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Container\ServiceProvider\BootableServiceProviderInterface;

class ApplicationServiceProvider extends AbstractServiceProvider implements BootableServiceProviderInterface
{
    public function boot(): void
    {
        $container = $this->getContainer();

        $container
            ->addServiceProvider(new CommandHandlingServiceProvider())
            ->addServiceProvider(new ProductApiServiceProvider());
    }

    public function provides(string $id): bool
    {
        // TODO: Implement provides() method.
    }

    public function register(): void
    {
        // TODO: Implement register() method.
    }
}