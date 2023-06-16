<?php

declare(strict_types=1);

namespace DetectLang;

use General\HTTP\Message\ServerRequestInterface;

function detectLang(string $lang, ServerRequestInterface $request): string
{
    if (!empty($request->getQuery('lang'))) {
        return $request->getQuery('lang');
    }
    if (!empty($request->getCookie('lang'))) {
        return $request->getCookie('lang');
    }
    if ($request->hasHeader('Accept-Language')) {
        $langs = $request->getHeader('Accept-Language');
        if (!empty($langs)) {
            return substr($langs[0], 0, 2);
        }
    }

    return $lang;
}
