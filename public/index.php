<?php

declare(strict_types=1);

use Framework\HTTP\Message\Response;
use Framework\HTTP\Message\ServerRequest;

use function Framework\HTTP\emitResponseToSApi;

/** @psalm-suppress MissingFile */
require __DIR__ . '/../vendor/autoload.php';

function home(ServerRequest $request): Response
{
    $name = ($request->query['name']) ?? 'guest';
    if (!is_string($name)) {
        return new Response(400, null);
    }

    $name = htmlspecialchars($name);
    $lang = detectLang('en', $request);

    $response = (new Response())
        ->addHeader('Content-Type', 'text/html; charset=UTF-8');
    $response->getBody()?->write("<h1>Hello,$name</h1><div>Lang is $lang</div>");

    return $response;
}

$request = createServerRequestFromGlobals(query: $_GET);

### Preprocessing

### Running

$response = home($request);

### Postprocessing
$response = $response->addHeader('X-frame-options', 'DENY');

### Sending
emitResponseToSApi($response);
