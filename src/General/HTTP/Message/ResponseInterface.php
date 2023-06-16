<?php

declare(strict_types=1);

namespace General\HTTP\Message;

interface ResponseInterface
{
    public function getStatusCode(): int;

    public function getBody(): ?StreamInterface;

    public function getHeaders(): array;

    public function addHeader(string $header, string $value): ResponseInterface;

    public function getHeader(string $header): array;

    public function withAddedHeader(string $header, string $value): ResponseInterface;
}
