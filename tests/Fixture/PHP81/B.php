<?php

declare(strict_types=1);

namespace PHP81;

class B
{
    public function __construct(
        private int $x
    ) {
    }

    public function test(): int
    {
        return $this->x;
    }
}
