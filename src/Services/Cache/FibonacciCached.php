<?php

declare(strict_types=1);


namespace Dale08\Fibonacci\Services\Cache;

use Dale08\Fibonacci\Services\Generator;
use Predis\Client;

final class FibonacciCached
{
    public function __construct(
        private Client $cache,
        private Generator $generator
    ) {
    }

    public function getByBorders(int $to, int $from = 0)
    {
        $cacheKey = 'fibonachi';
        if (empty($this->cache->lindex($cacheKey, $to))) {
            $generateFrom = $this->cache->llen($cacheKey);
            foreach ($this->generator->generateByBorders($to, $generateFrom) as $r) {
                $this->cache->rpush($cacheKey, $r);
            }
        }
        return $this->cache->lrange($cacheKey, $from, $to);
    }
}