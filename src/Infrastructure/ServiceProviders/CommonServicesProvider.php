<?php

namespace App\Infrastructure\ServiceProviders;

use App\Module\Common\Service\Generator\AmountGenerator;
use League\Container\Argument\Literal\IntegerArgument;
use League\Container\ServiceProvider\AbstractServiceProvider;

class CommonServicesProvider extends AbstractServiceProvider
{
    public function provides(string $id): bool
    {
        $services = [
            AmountGenerator::class,
        ];

        return in_array($id, $services);
    }

    public function register(): void
    {
        $container = $this->getContainer();

        $container
            ->add(AmountGenerator::class)
            ->addArgument(new IntegerArgument(21));
    }
}
