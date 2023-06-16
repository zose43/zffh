<?php

declare(strict_types=1);

namespace Framework\HTTP\Message;

use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class createServerRequestFromGlobalsTest extends TestCase
{
    public function testGlobals(): void
    {
        $server = [
            'REQUEST_METHOD' => 'POST',
            'CONTENT_TYPE' => 'text/plain, application/json',
            'CONTENT_LENGTH' => '10',
            'HTTP_ACCEPT_LANGUAGE' => 'en',
        ];
        $query = ['page' => '7'];
        $parsedBody = ['name' => 'John'];
        $cookie = ['theme' => 'dark'];
        $body = fopen('php://memory', 'rb+');
        fwrite($body, 'Body');

        $request = createServerRequestFromGlobals(
            $server,
            $query,
            $parsedBody,
            $cookie,
            $body
        );

        self::assertEquals([
            'Request-Method' => ['POST'],
            'Content-Type' => ['text/plain', 'application/json'],
            'Content-Length' => ['10'],
            'Accept-Language' => ['en'],
        ], $request->headers);
        self::assertEquals($query, $request->query);
        self::assertEquals($parsedBody, $request->getParsedBody());
        self::assertEquals($cookie, $request->cookie);
        self::assertEquals('Body', (string)$request->body);
        self::assertEquals($server['REQUEST_METHOD'], $request->getMethod());
    }

    public function testUri(): void
    {
        $server = [
            'REQUEST_METHOD' => 'POST',
            'HTTPS' => 'on',
            'HTTP_HOST' => 'localhost',
            'REQUEST_URI' => '/docs?page=7#chapter=2',
        ];
        $request = createServerRequestFromGlobals(
            $server,
        );
        /** @var Uri $uri */
        $uri = $request->getUri();

        self::assertEquals(
            'https://' . $server['HTTP_HOST'] . $server['REQUEST_URI'],
            (string)$uri
        );
    }

    public function testMultipleHeaders(): void
    {
        $headers = [
            'HTTP_HOST' => 'localhost',
            'REQUEST_METHOD' => 'POST',
            'CONTENT_TYPE' => 'text/plain, application/json',
            'HTTP_ACCEPT_LANGUAGE' => 'en',
        ];

        $request = createServerRequestFromGlobals($headers);
        self::assertEquals('text/plain, application/json', $request->getHeaderLine('Content-Type'));
        self::assertFalse($request->hasHeader('Content-Length'));
        self::assertTrue($request->hasHeader('Host'));
    }
}
