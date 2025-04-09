<?php

use App\ExternalApi\ApiClient\ShopApiHttpClient;
use App\ExternalApi\Products\DataProvider\ProductApiHttpClientInterface;
use App\Infrastructure\Container\ContainerFactory;
use App\Infrastructure\Kernel\Kernel;

require_once "vendor/autoload.php";

$container = ContainerFactory::create();
$kernel = (new Kernel())->setContainer($container);
$kernel->handleCommand($argv);




$container
    ->add(ProductApiHttpClientInterface::class, ShopApiHttpClient::class);

$commandHandler = $container->get('command_handler');
$commandHandler->handle($argv);