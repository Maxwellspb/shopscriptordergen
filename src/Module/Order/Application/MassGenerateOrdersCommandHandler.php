<?php

namespace App\Module\Order\Application;

use App\Module\Common\Service\Generator\AmountGenerator;
use App\Module\Common\Service\Generator\BooleanGenerator;
use App\Module\Customers\Domain\Customer\DataProvider\CustomersDataProviderInterface;
use App\Module\Customers\Domain\Customer\Model\Customer;
use App\Module\Customers\Domain\Customer\Service\CustomersGeneratorService;
use DateInterval;
use DatePeriod;
use DateTime;
use DateTimeInterface;

final readonly class MassGenerateOrdersCommandHandler
{
    public function __construct(
        private CustomersDataProviderInterface $customersDataProvider,
        private CustomersGeneratorService $customersGeneratorService,
        private AmountGenerator $customersAmountGenerator,
        private AmountGenerator $ordersAmountGenerator,
    )
    {
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

    public function __invoke(MassGenerateOrdersCommand $command) : void
    {
        $period = $this->getPeriod();

        $customerData = $this->customersDataProvider->fetchCustomerData();

        foreach ($period as $operationDate) {
            if (empty($customerData)) {
                break;
            }

            $this->generateCustomersWithOrders(clone $operationDate, $customerData);
        }
    }

    private function generateCustomersWithOrders(DateTimeInterface $operationDate, array &$customerData): void
    {
        if (empty($customerData)) {
            return;
        }

        $customersAmount = $this->customersAmountGenerator->nextInt();

        if ($this->shouldSkip()) {
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
        }
    }

    private function getPeriod() : DatePeriod
    {
        $dateStart = new DateTime('2023-01-01');
        $dateEnd = new DateTime('2025-01-01');

        $interval = DateInterval::createFromDateString('1 day');

        return new DatePeriod($dateStart, $interval, $dateEnd);
    }

    private function shouldSkip(): bool
    {
        return BooleanGenerator::averageTrue();
    }
}
