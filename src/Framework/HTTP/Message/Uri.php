<?php

declare(strict_types=1);

namespace Framework\HTTP\Message;

use General\HTTP\Message\UriInterface;

final readonly class Uri implements UriInterface
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

    public function getHost(): string
    {
        return $this->host;
    }

    public function getPort(): ?int
    {
        return $this->port;
    }

    public function getUser(): string
    {
        return $this->user;
    }

    public function getPass(): string
    {
        return $this->pass;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getQuery(): string
    {
        return $this->query;
    }

    public function getFragment(): string
    {
        return $this->fragment;
    }

    public function getScheme(): string
    {
        return $this->scheme;
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
