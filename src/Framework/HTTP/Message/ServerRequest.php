<?php

declare(strict_types=1);

namespace Framework\HTTP\Message;

use General\HTTP\Message\ServerRequestInterface;
use General\HTTP\Message\StreamInterface;
use General\HTTP\Message\UriInterface;

// todo make test
final class ServerRequest implements ServerRequestInterface
{
    /**
     * @psalm-param  array<string,string[]> $headers
     * @psalm-param Uri $uri
     * @psalm-param Stream $body
     */
    public function __construct(
        public readonly array           $query,
        public readonly UriInterface    $uri,
        public readonly string          $method,
        private ?array                  $parsedBody,
        public readonly array           $headers,
        public readonly array           $cookie,
        public readonly array           $server,
        public readonly StreamInterface $body
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

    public function getUri(): UriInterface
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

    public function addParsedBody(?array $body): ServerRequestInterface
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
