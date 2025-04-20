<?php

namespace App\Module\Customers\Domain\Customer\DataProvider;

use App\Module\Customers\Domain\Customer\Model\Customer;
use DateTime;

class CustomerNormalizer
{
    public function normalize(Customer $customer): array
    {
        return [
            'name' => $customer->name,
            'firstname' => $customer->firstName,
            'lastname' => $customer->lastName,
            'email' => $customer->email,
            'create_datetime' => $customer->getCreateDatetime() ?? new DateTime('now')
        ];
    }

    public function denormalize(array $customerData): Customer
    {
        return new Customer(
            name: $customerData['name'],
            firstName: $customerData['firstname'],
            lastName: $customerData['lastname'],
            email: $customerData['email'],
        );
    }
}
