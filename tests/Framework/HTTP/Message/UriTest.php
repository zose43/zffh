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

        self::assertEquals('https', $uri->getScheme());
        self::assertEquals('rdp', $uri->getHost());
        self::assertEquals(2022, $uri->getPort());
        self::assertEquals('admin:1199552112', $uri->getAuth());
        self::assertEquals('/docs', $uri->getPath());
        self::assertEquals('page=7', $uri->getQuery());
        self::assertEquals('chapter=2', $uri->getFragment());
    }
}
