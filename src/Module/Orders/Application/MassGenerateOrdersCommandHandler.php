<?php

namespace App\Module\Orders\Application;

use App\ExternalApi\Orders\Model\ApiOrder;
use App\ExternalApi\Products\Model\ApiProductDto;
use App\Module\Common\Service\Generator\AmountGenerator;
use App\Module\Common\Service\Generator\BooleanGenerator;
use App\Module\Customers\Domain\Customer\DataProvider\CustomersDataProviderInterface;
use App\Module\Customers\Domain\Customer\Model\Customer;
use App\Module\Customers\Domain\Customer\Service\CustomersGeneratorService;
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
    ) {
    }

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

            $this->generateOrdersForExistingCustomers(
                clone $operationDate,
                $productList,
            );

            $this->cancelYesterdaysOrders(clone $operationDate);
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
                'type' => 'for new customer',
            ]);

            $this
                ->ordersApiProvider
                ->completeOrder($orderId);
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
        return BooleanGenerator::rareTrue();
    }

    private function shouldSkipFirstOrder(): bool
    {
        return BooleanGenerator::rareTrue();
    }

    private function generateOrdersForExistingCustomers(
        DateTimeInterface $operationDate,
        array &$productList
    ): void {
        $previousDate = $operationDate->sub(new DateInterval('P1M'));

        $previousOrders = $this
            ->ordersApiProvider
            ->searchOrdersByDate($previousDate);

        if (empty($previousOrders)) {
            return;
        }

        $customerIds = array_map(
            static fn(ApiOrder $apiOrder) => $apiOrder->contactId,
            $previousOrders,
        );

        foreach ($customerIds as $customerId) {
            $orderDate = $this->randomizeOrderDate(clone $previousDate);

            if ($this->shouldSkipOperation()) {
                continue;
            }

            $orderId = $this->createOrder(
                $customerId,
                $productList,
                $orderDate
            );

            print_r([
                'customer_id' => $customerId,
                'order_id' => $orderId,
                'type' => 'for existing customer',
            ]);

            $this
                ->ordersApiProvider
                ->completeOrder($orderId);
        }
    }

    private function randomizeOrderDate(DateTimeInterface $orderDate): DateTimeInterface
    {
        $shouldAdd = false;
        if (BooleanGenerator::averageTrue() === true) {
            $shouldAdd = true;
        }

        $seq = [1, 2, 3];
        $daysInterval = $seq[array_rand($seq)];
        $interval = new DateInterval(sprintf('P%sD', $daysInterval));

        if ($shouldAdd === true) {
            $orderDate->add($interval);
        } else {
            $orderDate->sub($interval);
        }

        $orderDate->setTime(rand(8, 20), rand(0, 59), rand(0, 59));

        return $orderDate;
    }

    private function cancelYesterdaysOrders(DateTimeInterface $operationDate): void
    {
        $previousDate = $operationDate->sub(new DateInterval('P1D'));

        $previousOrders = $this
            ->ordersApiProvider
            ->searchOrdersByDate($previousDate);

        if (empty($previousOrders)) {
            return;
        }

        foreach ($previousOrders as $previousOrder) {
            if ($this->shouldRefundOrder()) {
                $this
                    ->ordersApiProvider
                    ->refundOrder($previousOrder->id);

                print_r([
                    'action' => 'refund',
                    'order_id' => $previousOrder->id,
                ]);
            }
        }
    }

    private function shouldRefundOrder(): bool
    {
        return BooleanGenerator::rareTrue();
    }
}
