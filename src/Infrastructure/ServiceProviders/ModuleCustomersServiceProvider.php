<?php

namespace App\Infrastructure\ServiceProviders;

use App\ExternalApi\Customers\DataProvider\CustomersApi;
use App\Module\Customers\Domain\Customer\DataProvider\CustomerNormalizer;
use App\Module\Customers\Domain\Customer\DataProvider\CustomersDataProviderInterface;
use App\Module\Customers\Domain\Customer\Service\CustomersApiProviderInterface;
use App\Module\Customers\Domain\Customer\Service\CustomersGeneratorService;
use App\Module\Customers\Infrastructure\CustomersApiProvider;
use App\Module\Customers\Infrastructure\CsvCustomersDataProvider;
use League\Container\ServiceProvider\AbstractServiceProvider;

class ModuleCustomersServiceProvider extends AbstractServiceProvider
{
    public function provides(string $id): bool
    {
        $services = [
            CustomersDataProviderInterface::class,
            CustomersApiProviderInterface::class,
            CustomersGeneratorService::class,
            CustomerNormalizer::class,
        ];

        return in_array($id, $services);
    }

    public function register(): void
    {
        $container = $this->getContainer();

        $container
            ->add(CustomersDataProviderInterface::class, CsvCustomersDataProvider::class)
            ->addArguments(
                [
                    $container->get('@customerData'),
                    CustomerNormalizer::class
                ]
            );

        $container
            ->add(CustomersGeneratorService::class)
            ->addArguments(
                [
                    CustomerNormalizer::class,
                    CustomersApiProviderInterface::class,
                ]
            );

        $container
            ->add(CustomersApiProviderInterface::class, CustomersApiProvider::class)
            ->addArgument(CustomersApi::class);

        $container->add(CustomerNormalizer::class);
    }
}
