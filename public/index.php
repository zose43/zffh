<?php

declare(strict_types=1);

use Framework\HTTP\Message\Response;
use Framework\HTTP\Message\ServerRequest;
use Framework\HTTP\Message\Stream;

use function Framework\HTTP\emitResponseToSApi;

/** @psalm-suppress MissingFile */
require __DIR__ . '/../vendor/autoload.php';

function home(ServerRequest $request): Response
{
    $response = new Response(400, null);
    $name = ($request->query['name']) ?? 'guest';
    if (!is_string($name)) {
        return $response;
    }

    $name = htmlspecialchars($name);
    $lang = detectLang('en', $request);
    $body = (new Stream(fopen('php://memory', 'rb+')))
        ->write("<h1>Hello,$name</h1><div>Lang is $lang</div>");
    $response->setBody($body)
        ->setStatusCode(200)
        ->setHeaders([
            'X-frame-options' => 'deny',
            'Content-Type' => 'text/plain; charset=UTF-8',
        ]);

    return $response;
}

$request = createServerRequestFromGlobals(query: $_GET);
$response = home($request);

emitResponseToSApi($response);
