<?php

namespace App\Infrastructure\ServiceProviders;

use App\Module\Customers\Domain\Service\CustomerDataProviderInterface;
use App\Module\Customers\Infrastructure\CsvCustomerDataProvider;
use League\Container\ServiceProvider\AbstractServiceProvider;

class ModuleCustomersServiceProvider extends AbstractServiceProvider
{
    public function provides(string $id): bool
    {
        $services = [
            CustomerDataProviderInterface::class
        ];

        return in_array($id, $services);
    }

    public function register(): void
    {
        $container = $this->getContainer();

        $container
            ->add(CustomerDataProviderInterface::class, CsvCustomerDataProvider::class)
            ->addArgument($container->get('@customerData'));
    }
}
