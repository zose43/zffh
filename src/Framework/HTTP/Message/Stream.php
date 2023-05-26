<?php

declare(strict_types=1);

namespace Framework\HTTP\Message;

final readonly class Stream
{
    /**
     * @param resource $stream
     */
    public function __construct(public mixed $stream)
    {
    }

    public function getContents(): string
    {
        return stream_get_contents($this->stream) ?: '';
    }

    public function rewind(): self
    {
        $this->seek(0);
        return $this;
    }

    public function seek(int $offset): self
    {
        fseek($this->stream, $offset);
        return $this;
    }

    public function read(int $length): string
    {
        return fread($this->stream, $length) ?: '';
    }

    public function __toString(): string
    {
        $this->rewind();
        return $this->getContents();
    }

    public function write(string $data): self
    {
        // todo check the write privilege
        fwrite($this->stream, $data);

        return $this;
    }
}
