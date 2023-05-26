<?php

declare(strict_types=1);

namespace Framework\HTTP\Message;

use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class ResponseTest extends TestCase
{
    public function testGetStatusCode(): void
    {
        $response = new Response(201, null);
        self::assertEquals(201, $response->getStatusCode());
    }

    public function testGetHeaders(): void
    {
        $headers = [
            'Accept-Language' => 'ru',
            'Request-Method' => 'POST',
        ];
        $response = new Response(201, null, $headers);
        self::assertEquals($headers, $response->getHeaders());
    }

    public function testGetBody(): void
    {
        $body = new Stream(fopen('php://memory', 'rb+'));
        $body->write('Good morning!');
        $response = new Response(201, body: $body);
        self::assertEquals($body, $response->getBody());
    }
}
