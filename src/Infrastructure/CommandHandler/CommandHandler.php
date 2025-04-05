<?php

namespace App\Infrastructure\CommandHandler;

use App\ExternalApi\Products\DataProvider\ProductApiHttpClientInterface;

class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly ProductApiHttpClientInterface $productApiHttpClient
    )
    {
    }

    public function handle(array $args): void
    {

    }
}