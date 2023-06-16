<?php

declare(strict_types=1);

namespace General\HTTP\Message;

interface StreamInterface
{
    public function getContents(): string;

    public function rewind(): StreamInterface;

    public function seek(int $offset): StreamInterface;

    public function read(int $length): string;

    public function write(string $data): StreamInterface;
}
