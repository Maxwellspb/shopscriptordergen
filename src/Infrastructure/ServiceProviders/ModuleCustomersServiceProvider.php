<?php

namespace App\Infrastructure\ServiceProviders;

use App\ExternalApi\Customers\DataProvider\CustomersApi;
use App\Module\Customers\Domain\Service\CustomerDataProviderInterface;
use App\Module\Customers\Domain\Service\CustomerGeneratorInterface;
use App\Module\Customers\Domain\Service\CustomerNormalizer;
use App\Module\Customers\Infrastructure\ApiCustomerGenerator;
use App\Module\Customers\Infrastructure\CsvCustomerDataProvider;
use League\Container\ServiceProvider\AbstractServiceProvider;

class ModuleCustomersServiceProvider extends AbstractServiceProvider
{
    public function provides(string $id): bool
    {
        $services = [
            CustomerDataProviderInterface::class,
            CustomerGeneratorInterface::class,
            CustomerNormalizer::class,
        ];

        return in_array($id, $services);
    }

    public function register(): void
    {
        $container = $this->getContainer();

        $container
            ->add(CustomerDataProviderInterface::class, CsvCustomerDataProvider::class)
            ->addArguments(
                [
                    $container->get('@customerData'),
                    CustomerGeneratorInterface::class
                ]
            );

        $container
            ->add(CustomerGeneratorInterface::class, ApiCustomerGenerator::class)
            ->addArguments(
                [
                    CustomersApi::class,
                    CustomerNormalizer::class
                ]
            );

        $container->add(CustomerNormalizer::class);
    }
}
