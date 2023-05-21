<?php

declare(strict_types=1);

namespace Framework\HTTP\Message;

use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class UriTest extends TestCase
{
    public function testUri(): void
    {
        $uri = new Uri('https://admin:1199552112@rdp:2022/docs?page=7#chapter=2');

        self::assertEquals('https', $uri->scheme);
        self::assertEquals('rdp', $uri->host);
        self::assertEquals(2022, $uri->port);
        self::assertEquals('admin:1199552112', $uri->getAuth());
        self::assertEquals('/docs', $uri->path);
        self::assertEquals('page=7', $uri->query);
        self::assertEquals('chapter=2', $uri->fragment);
    }
}
