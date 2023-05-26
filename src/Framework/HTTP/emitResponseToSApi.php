<?php

declare(strict_types=1);

namespace Framework\HTTP;

use Framework\HTTP\Message\Response;

function emitResponseToSApi(Response $response): void
{
    http_response_code($response->getStatusCode());
    /** @var string $value */
    foreach ($response->getHeaders() as $name => $value) {
        header("$name: $value");
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
