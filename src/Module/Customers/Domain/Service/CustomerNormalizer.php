<?php

namespace App\Module\Customers\Domain\Service;

use App\Module\Customers\Domain\Model\Customer;

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
}
