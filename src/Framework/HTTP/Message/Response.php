<?php

declare(strict_types=1);

namespace Framework\HTTP\Message;

final class Response
{
    /**
     * @psalm-param array<string,string[]> $headers
     */
    public function __construct(
        public readonly int $statusCode = 200,
        private ?Stream     $body = null,
        private array       $headers = []
    ) {
        $this->body ??= new Stream(fopen('php://memory', 'rb+'));
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getBody(): ?Stream
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
