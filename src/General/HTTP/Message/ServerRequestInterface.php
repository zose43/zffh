<?php

declare(strict_types=1);

namespace General\HTTP\Message;

use Framework\HTTP\Message\ServerRequest;

interface ServerRequestInterface
{
    public function getParsedBody(): ?array;

    public function setParsedBody(?array $parsedBody): ServerRequest;

    public function getMethod(): string;

    public function getUri(): UriInterface;

    public function getHeaderLine(string $header): string;

    public function hasHeader(string $header): bool;

    public function addParsedBody(?array $body): self;

    public function getQuery(string $value): string;

    /** @psalm-return   array<string,string[]> */
    public function getHeaders(): array;

    /** @psalm-return string[] */
    public function getHeader(string $header): array;

    public function getCookie(string $value): string;
}
