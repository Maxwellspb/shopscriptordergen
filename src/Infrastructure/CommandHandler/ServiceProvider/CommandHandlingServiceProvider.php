<?php

namespace App\Infrastructure\CommandHandler\ServiceProvider;

use App\ExternalApi\Products\DataProvider\ProductApiHttpClientInterface;
use App\Infrastructure\CommandHandler\CommandHandler;
use League\Container\ServiceProvider\AbstractServiceProvider;

class CommandHandlingServiceProvider extends AbstractServiceProvider
{
    public function provides(string $id): bool
    {
        $services = [
            CommandHandler::class
        ];

        return in_array($id, $services);
    }

    public function register(): void
    {
        $this->getContainer()
            ->add(CommandHandler::class)
            ->addArgument(ProductApiHttpClientInterface::class)
            ->setShared();
    }
}
