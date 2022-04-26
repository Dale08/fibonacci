<?php

declare(strict_types=1);

namespace Dale08\Fibonacci\Http\Controllers;

use Dale08\Fibonacci\Services\Cache\FibonacciCached;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class Fibonacci
{
    public function __construct(
        private FibonacciCached $service
    ) {
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        $params = $request->getQueryParams();
        $from = (int)($params['from'] ?? 0);
        $to = (int)(empty($params['to']) ? 10 : $params['to']);

        $fib = $this->service->getByBorders($to, $from);

        $response->getBody()
            ->write(
                '<h1>Срез Ряда</h1>
                        <div>' . implode(', <br />', $fib) . '</div>'
            );
        return $response;
    }
}