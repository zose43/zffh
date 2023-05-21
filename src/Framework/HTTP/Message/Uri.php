<?php

declare(strict_types=1);

namespace Framework\HTTP\Message;

final readonly class Uri
{
    public string $scheme;
    public string $host;
    public ?int $port;
    public string $user;
    public string $pass;
    public string $path;
    public string $query;
    public string $fragment;

    public function __construct(string $uri)
    {
        $uriData = parse_url($uri);
        $this->scheme = $uriData['scheme'] ?? '';
        $this->host = $uriData['host'] ?? '';
        $this->port = $uriData['port'] ?? null;
        $this->user = $uriData['user'] ?? '';
        $this->pass = $uriData['pass'] ?? '';
        $this->path = $uriData['path'] ?? '';
        $this->query = $uriData['query'] ?? '';
        $this->fragment = $uriData['fragment'] ?? '';
    }

    public function getAuth(): string
    {
        return $this->user . ($this->pass !== '' ? ':' . $this->pass : '');
    }

    public function __toString(): string
    {
        return $this->scheme . '://'
            . $this->host
            . ($this->getAuth() ? $this->getAuth() . '@' : '')
            . ($this->port ? ':' . $this->port : '')
            . $this->path
            . ($this->query ? '?' . $this->query : '')
            . ($this->fragment ? '#' . $this->fragment : '');
    }
}
