<?php

declare(strict_types=1);

namespace Tests\Framework\HTTP\Message;

use Framework\HTTP\Message\Stream;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertEquals;

/**
 * @internal
 */
final class StreamTest extends TestCase
{
    public function testEmpty(): void
    {
        $resource = fopen('php://memory', 'rb');
        $stream = new Stream($resource);
        self::assertEquals('', $stream->getContents());
    }

    public function testOver(): void
    {
        $resource = fopen('php://memory', 'rb+');
        fwrite($resource, 'Body');
        $stream = new Stream($resource);
        self::assertEquals('', $stream->getContents());
    }

    public function testRewind(): void
    {
        $resource = fopen('php://memory', 'rb+');
        fwrite($resource, 'Body');
        $stream = new Stream($resource);
        $stream->rewind();
        self::assertEquals('Body', $stream->getContents());
    }

    public function testSeek(): void
    {
        $resource = fopen('php://memory', 'rb+');
        fwrite($resource, 'Good day');
        $stream = new Stream($resource);
        $stream->rewind();
        self::assertEquals('day', $stream->seek(5)->getContents());
    }

    public function testRead(): void
    {
        $resource = fopen('php://memory', 'rb+');
        fwrite($resource, 'Good day');
        $stream = new Stream($resource);
        $stream->rewind();
        self::assertEquals('Good', $stream->read(4));
    }

    public function testToString(): void
    {
        $resource = fopen('php://memory', 'rb+');
        fwrite($resource, 'Good day');
        $stream = new Stream($resource);
        assertEquals('Good day', (string)$stream);
    }
}
