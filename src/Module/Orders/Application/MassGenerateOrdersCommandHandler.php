<?php

namespace App\Module\Orders\Application;

use App\ExternalApi\Orders\Model\AddOrderResponseDto;
use App\ExternalApi\Orders\Model\ApiOrderItemDto;
use App\ExternalApi\Orders\Model\ApiOrderRequestDto;
use App\ExternalApi\Products\Model\ApiProductDto;
use App\Module\Common\Service\Generator\AmountGenerator;
use App\Module\Common\Service\Generator\BooleanGenerator;
use App\Module\Customers\Domain\Customer\DataProvider\CustomersDataProviderInterface;
use App\Module\Customers\Domain\Customer\Model\Customer;
use App\Module\Customers\Domain\Customer\Service\CustomersGeneratorService;
use App\Module\Orders\Domain\Model\Order;
use App\Module\Orders\Domain\Service\OrdersApiProviderInterface;
use App\Module\Products\Domain\Service\ProductsApiProviderInterface;
use DateInterval;
use DatePeriod;
use DateTime;
use DateTimeInterface;

final readonly class MassGenerateOrdersCommandHandler
{
    public function __construct(
        private CustomersDataProviderInterface $customersDataProvider,
        private ProductsApiProviderInterface $productsApiProvider,
        private OrdersApiProviderInterface $ordersApiProvider,
        private CustomersGeneratorService $customersGeneratorService,
        private AmountGenerator $customersAmountGenerator,
        private AmountGenerator $ordersAmountGenerator,
    ) {
    }

    /*public function __invoke(MassGenerateOrdersCommand $command)
    {
        $dateStart = new DateTime('2023-01-01 08:00:00');
        $dateEnd = new DateTime('2025-04-12 20:00:00');

        $apiCustomers = $this->customersApi->listCustomers();
        $apiProducts = $this->productsApi->listProducts();

        $currentDate = clone $dateStart;

        while ($currentDate <= $dateEnd) {
            foreach ($apiCustomers as $customer) {
                if ($currentDate >= $dateEnd) {
                    break;
                }

                if (array_rand(range(1, 3)) % 2 !== 0) {
                    continue;
                }

                $operationDate = clone $currentDate;
                $operationDate->setTime(rand(8, 20), rand(0, 59), rand(0, 59));
                $productKey = array_rand($apiProducts);

                $orderDto = new ApiOrderDto(
                    $customer->id,
                    $operationDate,
                    array_rand(range(0, 100)) > 90,
                    [
                        new ApiOrderItemDto(
                            $apiProducts[$productKey]->skuId,
                            rand(1, 3)
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

                if (array_rand(range(0, 100)) > 90) {
                    $this->ordersApi->refundOrder($orderResult->orderId);
                    print_r(
                        [
                            'order_refunded' => $orderResult->orderId
                        ]
                    );
                }
            }

            $currentDate->modify('+1 day');
        }
    }*/

    public function __invoke(MassGenerateOrdersCommand $command): void
    {
        $period = $this->getPeriod();

        $customerData = $this->customersDataProvider->fetchCustomerData();
        $productList = $this->productsApiProvider->listProducts();

        foreach ($period as $operationDate) {
            if (empty($customerData)) {
                break;
            }

            $this->generateCustomersWithOrders(
                clone $operationDate,
                $customerData,
                $productList,
            );
        }
    }

    private function generateCustomersWithOrders(
        DateTimeInterface $operationDate,
        array &$customerData,
        array &$productList,
    ): void {
        if (empty($customerData)) {
            return;
        }

        $customersAmount = $this->customersAmountGenerator->nextInt();

        if ($this->shouldSkipOperation()) {
            return;
        }

        $newCustomers = array_splice($customerData, 0, $customersAmount);

        /** @var Customer $newCustomer */
        foreach ($newCustomers as $newCustomer) {
            $operationDate->setTime(rand(8, 20), rand(0, 59), rand(0, 59));
            $newCustomer->setCreateDatetime(clone $operationDate);

            $apiCustomerId = $this
                ->customersGeneratorService
                ->generateSingleCustomer($newCustomer);

            print_r([
                'customer_id' => $apiCustomerId,
                'created_at' => $operationDate->format('Y-m-d H:i:s'),
            ]);

            if ($this->shouldSkipFirstOrder()) {
                continue;
            }

            $orderId = $this->createOrder(
                $apiCustomerId,
                $productList,
                clone $operationDate
            );

            print_r([
                'customer_id' => $apiCustomerId,
                'order_id' => $orderId,
            ]);
        }
    }

    private function createOrder(
        int $apiCustomerId,
        array &$productList,
        DateTimeInterface $operationDate
    ): int {
        /** @var ApiProductDto $product */
        $product = $productList[array_rand($productList)];

        return $this
            ->ordersApiProvider
            ->placeOrder(
                $apiCustomerId,
                $product,
                $operationDate
            );
    }

    private function getPeriod(): DatePeriod
    {
        $dateStart = new DateTime('2021-01-01');
        $dateEnd = new DateTime('2025-04-01');

        $interval = DateInterval::createFromDateString('1 day');

        return new DatePeriod($dateStart, $interval, $dateEnd);
    }

    private function shouldSkipOperation(): bool
    {
        return BooleanGenerator::averageTrue();
    }

    private function shouldSkipFirstOrder(): bool
    {
        return BooleanGenerator::rareTrue();
    }
}
