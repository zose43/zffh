<?php

declare(strict_types=1);

namespace Framework\HTTP\Message;

final class Response
{
    public function __construct(
        private int    $statusCode,
        private string $body = '',
        private array  $headers = []
    ) {
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function setStatusCode(int $statusCode): Response
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function setBody(string $body): Response
    {
        $this->body = $body;
        return $this;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function setHeaders(array $headers): Response
    {
        $this->headers = $headers;
        return $this;
    }
}
