<?php

namespace App\Module\Customers\Domain\Customer\DataProvider;

use App\Module\Customers\Domain\Customer\Model\Customer;

class CustomerNormalizer
{
    public function normalize(Customer $customer): array
    {
        return [
            'full_name' => $customer->fullName,
            'name' => $customer->name,
            'surname' => $customer->surname,
            'email' => $customer->email,
            'sex' => $customer->sex,
        ];
    }

    public function denormalize(array $customerData)
    {
        return new Customer(
            fullName: $customerData['full_name'],
            name: $customerData['name'],
            surname: $customerData['surname'],
            email: $customerData['email'],
            sex: $customerData['sex'],
        );
    }
}
