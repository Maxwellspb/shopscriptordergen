<?php

namespace App\Infrastructure\Container;

use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Container\ServiceProvider\BootableServiceProviderInterface;
use Symfony\Component\Dotenv\Dotenv;

class ConfigurationProvider extends AbstractServiceProvider implements BootableServiceProviderInterface
{
    public function provides(string $id): bool
    {
        return false;
    }

    public function register(): void
    {
        // TODO: Implement register() method.
    }

    public function boot(): void
    {
        $container = $this->getContainer();

        $dotenv = new Dotenv();
        $dotenv->loadEnv($container->get('@rootEnv'));
        $container->add(Dotenv::class, $dotenv);


    }
}
