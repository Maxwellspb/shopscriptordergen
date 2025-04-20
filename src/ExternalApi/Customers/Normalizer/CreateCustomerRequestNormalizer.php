<?php

namespace App\ExternalApi\Customers\Normalizer;

use App\ExternalApi\Customers\DataProvider\CreateCustomerRequestDto;

class CreateCustomerRequestNormalizer
{
    public function normalize(CreateCustomerRequestDto $createCustomerRequestDto): array
    {
        return [
            'name' => $createCustomerRequestDto->name,
            'firstname' => $createCustomerRequestDto->firstname,
            'lastname' => $createCustomerRequestDto->lastname,
            'email' => $createCustomerRequestDto->email,
            'create_datetime' => $createCustomerRequestDto->createDatetime->format('Y-m-d H:i:s'),
        ];
    }
}
