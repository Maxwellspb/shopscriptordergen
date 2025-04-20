<?php

namespace App\Module\Customers\Domain\Customer\Model;

use DateTimeInterface;

readonly class Customer
{
    private ?DateTimeInterface $createDatetime;

    public function __construct(
        public string $name,
        public string $firstName,
        public string $lastName,
        public string $email,
    ) {
    }

    public function setCreateDatetime(DateTimeInterface $createDatetime): Customer
    {
        $this->createDatetime = $createDatetime;

        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getCreateDatetime(): ?DateTimeInterface
    {
        return $this->createDatetime;
    }
}
