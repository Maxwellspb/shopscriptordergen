<?php

namespace App\Infrastructure\CommandHandler;

use App\ExternalApi\Products\DataProvider\ProductsApi;

class CommandHandler
{
    public function __construct(
        private readonly ProductsApi $productsApi,
    )
    {
    }

    public function handle(array $args): void
    {

    }
}