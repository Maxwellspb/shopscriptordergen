<?php

namespace App\Infrastructure\ServiceProviders;

use App\ExternalApi\Customers\DataProvider\CustomersApi;
use App\Module\Customers\Domain\Customer\DataProvider\CustomerNormalizer;
use App\Module\Customers\Domain\Customer\DataProvider\ExternalCustomersDataProviderInterface;
use App\Module\Customers\Domain\Customer\DataProvider\InternalCustomersDataProviderInterface;
use App\Module\Customers\Domain\Customer\Service\CustomersGeneratorInterface;
use App\Module\Customers\Infrastructure\ApiCustomersDataProvider;
use App\Module\Customers\Infrastructure\ApiCustomersGenerator;
use App\Module\Customers\Infrastructure\CsvCustomersDataProvider;
use League\Container\ServiceProvider\AbstractServiceProvider;

class ModuleCustomersServiceProvider extends AbstractServiceProvider
{
    public function provides(string $id): bool
    {
        $services = [
            InternalCustomersDataProviderInterface::class,
            ExternalCustomersDataProviderInterface::class,
            CustomersGeneratorInterface::class,
            CustomerNormalizer::class,
        ];

        return in_array($id, $services);
    }

    public function register(): void
    {
        $container = $this->getContainer();

        $container
            ->add(InternalCustomersDataProviderInterface::class, CsvCustomersDataProvider::class)
            ->addArguments(
                [
                    $container->get('@customerData'),
                    CustomerNormalizer::class
                ]
            );

        $container
            ->add(ExternalCustomersDataProviderInterface::class, ApiCustomersDataProvider::class)
            ->addArgument(CustomersApi::class);

        $container
            ->add(CustomersGeneratorInterface::class, ApiCustomersGenerator::class)
            ->addArguments(
                [
                    CustomersApi::class,
                    CustomerNormalizer::class
                ]
            );

        $container->add(CustomerNormalizer::class);
    }
}
