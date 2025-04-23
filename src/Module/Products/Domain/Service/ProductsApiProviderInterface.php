<?php

namespace App\Module\Products\Domain\Service;

interface ProductsApiProviderInterface
{
    /**
     * @return array
     */
    public function listProducts(): array;
}
