<?php

declare(strict_types=1);

namespace Dale08\Fibonacci\Http\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class Home
{
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // your code to access items in the container... $this->container->get('');
        $response->getBody()
            ->write(
                '
                <h1>Срез чисел Фибоначчи</h1>
                <form method="get" action="/fibonacci">
                <input type="text" name="from" placeholder="Порядковый номер от (0 по-умолчанию)" style="min-width: 300px;"/>
                <input type="text" name="to" placeholder="Порядковый номер до (10 по-умолчанию)" style="min-width: 300px;"/>
                <button>Поехали!</button>
                </form>'
            );
        return $response;
    }
}