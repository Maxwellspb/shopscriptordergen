<?php

namespace App\ExternalApi\Customers\DataProvider;

use App\ExternalApi\Customers\Model\ApiCustomerDto;
use App\ExternalApi\Products\Model\ApiProductDto;

class ApiCustomersMapper
{
    /**
     * @param array $customerData
     * @return ApiProductDto[]
     */
    public function map(array $customerData): array
    {
        $customers = [];
        foreach ($customerData as $customer) {
            $customers[] = new ApiCustomerDto(
                id: (int)$customer['id'],
                name: $customer['name'],
                firstName: $customer['firstname'],
                lastName: $customer['lastname'],
                email: $customer['email'][0],
                affiliateBonus: (float) $customer['affiliate_bonus'],
            );
        }

        return $customers;
    }
}
