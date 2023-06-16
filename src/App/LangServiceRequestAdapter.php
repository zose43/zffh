<?php

declare(strict_types=1);

namespace App;

use DetectLang\LangRequestContract;
use General\HTTP\Message\ServerRequestInterface;

final readonly class LangServiceRequestAdapter implements LangRequestContract
{
    public function __construct(private ServerRequestInterface $origin)
    {
    }

    public function getQuery(string $value): string
    {
        return $this->origin->getQuery($value);
    }

    /** @psalm-return   array<string,string[]> */
    public function getHeaders(): array
    {
        return $this->origin->getHeaders();
    }

    /** @psalm-return string[] */
    public function getHeader(string $header): array
    {
        return $this->origin->getHeader($header);
    }

    public function getCookie(string $value): string
    {
        return $this->origin->getCookie($value);
    }

    public function hasHeader(string $header): bool
    {
        return $this->origin->hasHeader($header);
    }

    public function getHeaderLine(string $header): string
    {
        return $this->origin->getHeaderLine($header);
    }

    public function getParsedBody(): ?array
    {
        return $this->origin->getParsedBody();
    }
}
