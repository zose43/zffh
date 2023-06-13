<?php

declare(strict_types=1);

namespace Framework\HTTP\Message;

use DetectLang\LangRequestContract;

// todo make test
final class ServerRequest implements LangRequestContract
{
    /**
     * @psalm-param  array<string,string[]> $headers
     */
    public function __construct(
        public readonly array  $query,
        public readonly Uri    $uri,
        public readonly string $method,
        private ?array         $parsedBody,
        public readonly array  $headers,
        public readonly array  $cookie,
        public readonly array  $server,
        public readonly Stream $body
    ) {
    }

    public function getParsedBody(): ?array
    {
        return $this->parsedBody;
    }

    public function setParsedBody(?array $parsedBody): ServerRequest
    {
        $this->parsedBody = $parsedBody;
        return $this;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getUri(): Uri
    {
        return $this->uri;
    }

    public function getHeaderLine(string $header): string
    {
        return implode(', ', $this->headers[$header] ?? []);
    }

    public function hasHeader(string $header): bool
    {
        return array_key_exists($header, $this->headers);
    }

    public function addParsedBody(?array $body): self
    {
        $clone = clone $this;
        $clone->parsedBody = $body;
        return $clone;
    }

    public function getQuery(string $value): string
    {
        return empty($this->query[$value]) ? '' : (string)$this->query[$value];
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getHeader(string $header): array
    {
        return $this->headers[$header] ?? [];
    }

    public function getCookie(string $value): string
    {
        return empty($this->cookie[$value]) ? '' : (string)$this->cookie[$value];
    }
}
