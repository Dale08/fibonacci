<?php

declare(strict_types=1);


namespace Dale08\Fibonacci\Services;

interface Generator
{
    public function generateByBorders(int $to, int $from = 0): \Generator;
}