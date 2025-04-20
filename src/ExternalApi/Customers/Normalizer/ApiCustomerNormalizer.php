<?php

namespace App\ExternalApi\Customers\Normalizer;

use App\ExternalApi\Customers\Model\ApiCustomerDto;

class ApiCustomerNormalizer
{
    public function denormalize(array $customerData): ApiCustomerDto
    {
        return new ApiCustomerDto(
            id: (int)$customerData['id'],
            name: $customerData['name'],
            firstName: $customerData['firstname'],
            lastName: $customerData['lastname'],
            email: $customerData['email'][0],
            affiliateBonus: (float) $customerData['affiliate_bonus'],
        );
    }
}
