<?php

declare(strict_types=1);

namespace Framework\HTTP\Message;

final readonly class ServerRequest implements Request
{
    public function __construct(
        public array  $query,
        public Uri    $uri,
        public string $method,
        public ?array $parsedBody,
        public array  $headers,
        public array  $cookie,
        public array  $server,
        public Stream $body,
    ) {
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getUri(): Uri
    {
        return $this->uri;
    }
}
