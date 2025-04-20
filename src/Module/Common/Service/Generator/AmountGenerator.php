<?php

namespace App\Module\Common\Service\Generator;

use Generator;

class AmountGenerator
{
    private int $prevInt = 0;
    private int $currentInt = 1;

    private array $sequence = [];
    private Generator $generator;

    public function __construct(
        private int $maxAmount,
    ) {
        $nextInt = 0;
        while ($nextInt !== $this->maxAmount) {
            $nextInt = $this->prevInt + $this->currentInt;
            $this->prevInt = $this->currentInt;
            $this->currentInt = $nextInt;

            $this->sequence[] = $nextInt;
        }

        $this->generator = $this->generate();
    }

    public function nextInt(): int
    {
        if (!$this->generator->valid()) {
            $this->generator = $this->generate();
        }

        $int = $this->generator->current();
        $this->generator->next();

        return $int;
    }

    private function generate(): Generator
    {
        $count = count($this->sequence);
        for ($i = 0; $i < $count; $i++) {
            yield $this->sequence[$i];
        }

        for ($i = $count - 2; $i >= 0; $i--) {
            yield $this->sequence[$i];
        }
    }
}