<?php

declare(strict_types=1);

use Framework\HTTP\Message\Response;
use Framework\HTTP\Message\ServerRequest;

/** @psalm-suppress MissingFile */
require __DIR__ . '/../vendor/autoload.php';

function home(ServerRequest $request): Response
{
    $response = new Response(400);
    $name = ($request->query['name']) ?? 'guest';
    if (!is_string($name)) {
        $response->setBody('Name not a string!');
        return $response;
    }

    $name = htmlspecialchars($name);
    $lang = detectLang('en', $request);
    $response->setBody("<h1>Hello,$name</h1><div>Lang is $lang</div>")
        ->setStatusCode(200)
        ->setHeaders([
            'X-frame-options' => 'deny',
            'Content-Type' => 'text/html; charset=UTF-8',
        ]);

    return $response;
}

$request = createServerRequestFromGlobals(query: $_GET);
$response = home($request);

http_response_code($response->getStatusCode());
/** @var string $value */
/** @var string $name */
foreach ($response->getHeaders() as $name => $value) {
    header("$name: $value");
}
echo $response->getBody();
