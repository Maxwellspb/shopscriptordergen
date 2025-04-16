<?php

namespace App\Infrastructure\ServiceProviders;

use App\ExternalApi\Customers\DataProvider\CustomersApi;
use App\Module\Customers\Domain\Customer\DataProvider\CustomerNormalizer;
use App\Module\Customers\Domain\Customer\DataProvider\ApiCustomersProviderInterface;
use App\Module\Customers\Domain\Customer\DataProvider\CustomersDataProviderInterface;
use App\Module\Customers\Domain\Customer\Service\CustomersApiInterface;
use App\Module\Customers\Domain\Customer\Service\CustomersGeneratorService;
use App\Module\Customers\Infrastructure\ApiCustomersProvider;
use App\Module\Customers\Infrastructure\CustomersApiAdapter;
use App\Module\Customers\Infrastructure\CsvCustomersDataProvider;
use League\Container\ServiceProvider\AbstractServiceProvider;

class ModuleCustomersServiceProvider extends AbstractServiceProvider
{
    public function provides(string $id): bool
    {
        $services = [
            CustomersDataProviderInterface::class,
            ApiCustomersProviderInterface::class,
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
                    CustomersApiInterface::class,
                ]
            );

        $container
            ->add(ApiCustomersProviderInterface::class, ApiCustomersProvider::class)
            ->addArgument(CustomersApi::class);

        $container
            ->add(CustomersApiInterface::class, CustomersApiAdapter::class)
            ->addArgument(CustomersApi::class);

        $container->add(CustomerNormalizer::class);
    }
}
