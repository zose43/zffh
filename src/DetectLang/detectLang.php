<?php

declare(strict_types=1);

namespace DetectLang;

function detectLang(string $lang, LangRequestContract $request): string
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
