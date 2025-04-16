<?php

namespace App\Module\Customers\Infrastructure;

use App\Module\Customers\Domain\Customer\DataProvider\CustomerNormalizer;
use App\Module\Customers\Domain\Customer\DataProvider\CustomersDataProviderInterface;
use App\Module\Customers\Domain\Customer\Model\Customer;

readonly class CsvCustomersDataProvider implements CustomersDataProviderInterface
{
    public function __construct(
        private string $filePath,
        private CustomerNormalizer $customerNormalizer,
    ) {
    }

    /**
     * @return Customer[]|array
     */
    public function fetchCustomerData(): array
    {
        $csvData = array_map("str_getcsv", file($this->filePath, FILE_SKIP_EMPTY_LINES));
        $keys = array_shift($csvData);

        $customers = [];
        foreach ($csvData as $row) {
            $data = array_combine($keys, $row);

            $customers[] = $this
                ->customerNormalizer
                ->denormalize($data);
        }

        return $customers;
    }
}
