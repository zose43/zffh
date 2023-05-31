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
            'Accept-Language' => ['ru'],
            'Request-Method' => ['POST'],
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

    public function testAddHeader(): void
    {
        $response = new Response(200, null);
        $response = $response->addHeader('Content-Type', 'text/plain; charset=UTF-8')
            ->addHeader('X-frame-options', 'deny');
        self::assertEquals([
            'Content-Type' => ['text/plain; charset=UTF-8'],
            'X-frame-options' => ['deny'],
        ], $response->getHeaders());
    }

    public function testGetHeader(): void
    {
        $response = new Response(200, null);
        $response = $response->addHeader('Content-Type', 'text/plain; charset=UTF-8');
        self::assertEquals(['text/plain; charset=UTF-8'], $response->getHeader('Content-Type'));
    }

    public function testGetEmptyHeader(): void
    {
        $response = new Response(200, null);
        self::assertEquals([], $response->getHeader('Content-Type'));
    }

    public function testMultipleHeader(): void
    {
        $response = new Response();
        $response = $response->addHeader('Content-Type', 'text/plain; charset=UTF-8')
            ->addHeader('Accept-Language', 'en')
            ->withAddedHeader('Content-Type', 'application/json')
            ->addHeader('Accept-Language', 'fr');

        self::assertEquals([
            'Content-Type' => [
                'text/plain; charset=UTF-8',
                'application/json',
            ],
            'Accept-Language' => ['fr'],
        ], $response->getHeaders());
    }
}
