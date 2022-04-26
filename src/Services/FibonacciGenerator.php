<?php

declare(strict_types=1);


namespace Dale08\Fibonacci\Services;

final class FibonacciGenerator implements Generator
{
    public function generateByBorders(int $to, int $from = 0): \Generator {
        while ($from <= $to) {
            yield round((((sqrt(5) + 1) / 2) ** $from++) / sqrt(5));
        }
    }
}