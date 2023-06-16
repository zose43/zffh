<?php

declare(strict_types=1);

namespace App;

use Framework\HTTP\Message\ServerRequest;
use Framework\HTTP\Message\Stream;
use Framework\HTTP\Message\Uri;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class LangServiceRequestAdapterTest extends TestCase
{
    public function testAdapter(): void
    {
        $request = new ServerRequest(
            [],
            new Uri('news/page/2'),
            'GET',
            $queryParams = ['name' => 'Kir', 'age' => '27'],
            $headers = [
                'X-Type' => ['class', 'interface'],
                'X-Specification' => ['test'],
            ],
            ['Cookie' => 'value'],
            [
                'CONTENT_TYPE' => 'text/plain, application/json',
                'CONTENT_LENGTH' => '10',
                'HTTP_ACCEPT_LANGUAGE' => 'en',
            ],
            new Stream(fopen('php://memory', 'rb'))
        );
        $adapter = new LangServiceRequestAdapter($request);

        self::assertEquals('', $adapter->getQuery('lang'));
        self::assertTrue($adapter->hasHeader('X-Specification'));
        self::assertFalse($adapter->hasHeader('X-Name'));
        self::assertEquals('value', $adapter->getCookie('Cookie'));
        self::assertEquals($headers, $adapter->getHeaders());
        self::assertEquals(['class', 'interface'], $adapter->getHeader('X-Type'));
        self::assertEquals('class, interface', $adapter->getHeaderLine('X-Type'));
        self::assertEquals($queryParams, $adapter->getParsedBody());
    }
}
