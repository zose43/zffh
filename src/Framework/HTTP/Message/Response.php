<?php

declare(strict_types=1);

namespace Framework\HTTP\Message;

use General\HTTP\Message\ResponseInterface;
use General\HTTP\Message\StreamInterface;

final class Response implements ResponseInterface
{
    /**
     * @psalm-param array<string,string[]> $headers
     * @psalm-param Stream|null $body
     */
    public function __construct(
        public readonly int      $statusCode = 200,
        private ?StreamInterface $body = null,
        private array            $headers = []
    ) {
        $this->body ??= new Stream(fopen('php://memory', 'rb+'));
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getBody(): ?StreamInterface
    {
        return $this->body;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function addHeader(string $header, string $value): self
    {
        $clone = clone $this;
        $clone->headers[$header] = [$value];
        return $clone;
    }

    public function getHeader(string $header): array
    {
        return $this->headers[$header] ?? [];
    }

    public function withAddedHeader(string $header, string $value): self
    {
        $clone = clone $this;
        $clone->headers[$header][] = $value;
        return $clone;
    }
}
