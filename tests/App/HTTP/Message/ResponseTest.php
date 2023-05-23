<?php

declare(strict_types=1);

namespace Tests\App\HTTP\Message;

use Framework\HTTP\Message\Response;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class ResponseTest extends TestCase
{
    public function testGetStatusCode(): void
    {
        $response = new Response(201);
        self::assertEquals(201, $response->getStatusCode());
    }

    public function testGetHeaders(): void
    {
        $headers = [
            'Accept-Language' => 'ru',
            'Request-Method' => 'POST',
        ];
        $response = new Response(201, headers: $headers);
        self::assertEquals($headers, $response->getHeaders());
    }

    public function testGetBody(): void
    {
        $body = 'Good morning!';
        $response = new Response(201, body: $body);
        self::assertEquals($body, $response->getBody());
    }
}
