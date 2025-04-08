<?php

namespace App\Module\Customers\Infrastructure;

use App\Module\Customers\Domain\Service\CustomerDataProviderInterface;

readonly class CsvCustomerDataProvider implements CustomerDataProviderInterface
{
    public function __construct(
        private string $filePath,
    )
    {

    }

    public function fetchCustomerData(): array
    {
        $csvData = array_map("str_getcsv", file($this->filePath, FILE_SKIP_EMPTY_LINES));
        $keys = array_shift($csvData);

        foreach ($csvData as $row => $values) {
            $csvData[$row] = array_combine($keys, $values);
        }

        $a = 1;
    }
}
