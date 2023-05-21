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
            'HTTP_HOST' => 'localhost',
            'HTTPS' => 'on',
            'REQUEST_URI' => '/docs?page=7#chapter=2',
            'REQUEST_METHOD' => 'POST',
            'CONTENT_TYPE' => 'text/plain',
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
            'Content-Type' => 'text/plain',
            'Content-Length' => '10',
            'Host' => 'localhost',
            'Accept-Language' => 'en',
        ], $request->headers);
        self::assertEquals($query, $request->query);
        self::assertEquals($parsedBody, $request->parsedBody);
        self::assertEquals($cookie, $request->cookie);
        self::assertEquals('Body', (string)$request->body);
        self::assertEquals(
            'https://' . $server['HTTP_HOST'] . $server['REQUEST_URI'],
            (string)$request->getUri()
        );
        self::assertEquals($server['REQUEST_METHOD'], $request->getMethod());
    }
}
