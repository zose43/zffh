<?php

declare(strict_types=1);

use Framework\HTTP\Message\ServerRequest;

function detectLang(string $lang, ServerRequest $request): string
{
    if (!empty($request->query['lang']) && is_string($request->query['lang'])) {
        return $request->query['lang'];
    }
    if (!empty($request->cookie['lang'])) {
        return (string)$request->cookie['lang'];
    }
    if (!empty($request->headers['Accept-Language'])) {
        return substr((string)$request->headers['Accept-Language'], 0, 2);
    }

    return $lang;
}
