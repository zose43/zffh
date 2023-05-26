<?php

declare(strict_types=1);

use Framework\HTTP\Message\ServerRequest;
use Framework\HTTP\Message\Stream;
use Framework\HTTP\Message\Uri;

/**
 * @param array<string,string>|null $server
 * @param array<string,array|string>|null $query
 * @param array<string,array|string>|null $parsedBody
 * @param array<string,string>|null $cookie
 * @param resource|null $body
 */
function createServerRequestFromGlobals(
    ?array $server = null,
    ?array $query = null,
    ?array $parsedBody = null,
    ?array $cookie = null,
    mixed  $body = null,
): ServerRequest {
    $server ??= $_SERVER;
    $headers = [
        'Content-Type' => $server['CONTENT_TYPE'],
        'Content-Length' => $server['CONTENT_LENGTH'],
    ];
    foreach ($server as $name => $item) {
        if (str_starts_with($name, 'HTTP_')) {
            $name = ucwords(strtolower(str_replace('_', '-', substr($name, 5))), '-');
            $headers[$name] = $item;
        }
    }

    return new ServerRequest(
        query: $query ?? $_GET,
        uri: new Uri((empty($server['HTTPS']) ? 'http' : 'https') . '://' . $server['HTTP_HOST'] . $server['REQUEST_URI']),
        method: $server['REQUEST_METHOD'],
        parsedBody: $parsedBody ?? ($_POST ?: null),
        headers: $headers,
        cookie: $cookie ?? $_COOKIE,
        server: $server,
        body: new Stream($body ?? fopen('php://input', 'rb')),
    );
}
