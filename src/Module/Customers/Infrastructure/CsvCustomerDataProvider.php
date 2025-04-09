<?php

namespace App\Module\Customers\Infrastructure;

use App\Module\Customers\Domain\Model\Customer;
use App\Module\Customers\Domain\Service\CustomerDataProviderInterface;

readonly class CsvCustomerDataProvider implements CustomerDataProviderInterface
{
    public function __construct(
        private string $filePath,
    ) {
    }

    public function fetchCustomerData(): array
    {
        $csvData = array_map("str_getcsv", file($this->filePath, FILE_SKIP_EMPTY_LINES));
        $keys = array_shift($csvData);

        $customersCollection = [];
        foreach ($csvData as $row) {
            $data = array_combine($keys, $row);

            $customersCollection[] = new Customer(
                fullName: $data['full_name'],
                name: $data['name'],
                surname: $data['surname'],
                email: $data['email'],
                sex: $data['sex'],
            );
        }

        return $customersCollection;
    }
}
