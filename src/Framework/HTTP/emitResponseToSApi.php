<?php

declare(strict_types=1);

namespace Framework\HTTP;

use Framework\HTTP\Message\Response;

function emitResponseToSApi(Response $response): void
{
    http_response_code($response->getStatusCode());
    /** @var array $values */
    foreach ($response->getHeaders() as $name => $values) {
        /** @var string $value */
        foreach ($values as $value) {
            header("$name: $value", false);
        }
    }

    $body = $response->getBody();
    if ($body) {
        $body->rewind();

        do {
            $content = $body->read((2 << 10) * 8);
            echo $content;
        } while ($content !== '');
    }
}
