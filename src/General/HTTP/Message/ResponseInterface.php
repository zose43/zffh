<?php

declare(strict_types=1);

namespace General\HTTP\Message;

use Framework\HTTP\Message\Stream;

interface ResponseInterface
{
    public function getStatusCode(): int;

    public function getBody(): ?Stream; // todo chg to interface

    public function getHeaders(): array;

    public function addHeader(string $header, string $value): self;

    public function getHeader(string $header): array;

    public function withAddedHeader(string $header, string $value): self;
}
