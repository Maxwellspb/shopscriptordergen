<?php

namespace App\ExternalApi\Products\DataProvider;

interface ProductApiHttpClientInterface
{
    public function get(string $route, array $parameters): array;
}