<?php

namespace App\Module\Order\Application;

use App\ExternalApi\Customers\DataProvider\CustomersApi;
use App\ExternalApi\Orders\DataProvider\OrdersApi;
use App\ExternalApi\Orders\Model\ApiOrderDto;
use App\ExternalApi\Orders\Model\ApiOrderItemDto;
use App\ExternalApi\Products\DataProvider\ProductsApi;
use DateTime;

final readonly class MassGenerateOrdersCommandHandler
{
    //TODO Заменить CustomerApi на externaldata provider
    public function __construct(
        private CustomersApi $customersApi,
        private OrdersApi $ordersApi,
        private ProductsApi $productsApi,
    )
    {
    }

    public function __invoke(MassGenerateOrdersCommand $command)
    {
        $dateStart = new DateTime('2023-01-01 08:00:00');
        $dateEnd = new DateTime('2025-04-11 20:00:00');

        $apiCustomers = $this->customersApi->listCustomers();
        $apiProducts = $this->productsApi->listProducts();

        $currentDate = clone $dateStart;

        while ($currentDate <= $dateEnd) {
            foreach ($apiCustomers as $customer) {
                if ($currentDate >= $dateEnd) {
                    break;
                }

                if (array_rand(range(1,3)) % 2 !== 0) {
                    continue;
                }

                $operationDate = clone $currentDate;
                $operationDate->setTime(rand(8, 20), rand(0, 59), rand(0, 59));
                $productKey = array_rand($apiProducts);

                $orderDto = new ApiOrderDto(
                    $customer->id,
                    $operationDate,
                    true,
                    [
                        new ApiOrderItemDto(
                            $apiProducts[$productKey]->skuId,
                            rand(1,3)
                        )
                    ]
                );

                $orderResult = $this->ordersApi->addOrder($orderDto);

                print_r([
                    'order_id' => $orderResult->orderId,
                    'create_datetime' => $orderResult->creatDatetime->format('Y-m-d H:i:s'),
                    'contact_id' => $orderResult->contactId,
                ]);

                $this->ordersApi->completeOrder($orderResult->orderId);
            }

            $currentDate->modify('+1 day');
        }
    }
}
