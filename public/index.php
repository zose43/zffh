<?php

declare(strict_types=1);

use App\LangServiceRequestAdapter;
use Framework\HTTP\Message\Response;
use Framework\HTTP\Message\ServerRequest;

use General\HTTP\Message\ResponseInterface;

use function DetectLang\detectLang;
use function Framework\HTTP\emitResponseToSApi;

/** @psalm-suppress MissingFile */
require __DIR__ . '/../vendor/autoload.php';

function home(ServerRequest $request): ResponseInterface
{
    $name = $request->getQuery('name') ?: 'guest';
    $name = htmlspecialchars($name);
    $lang = detectLang('en', new LangServiceRequestAdapter($request));

    $response = (new Response())
        ->addHeader('Content-Type', 'text/html; charset=UTF-8');
    $response->getBody()?->write("<h1>Hello,$name</h1><div>Lang is $lang</div>");

    return $response;
}

### Grabbing
$request = createServerRequestFromGlobals();

### Preprocessing
// todo no test
if ($request->method !== 'POST'
    && str_starts_with($request->getHeaderLine('Content-Type'), 'application/x-www-form-urlencoded')) {
    parse_str((string)$request->body, $data);
    $request = $request->setParsedBody($data);
}

### Running

$response = home($request);


### Postprocessing
$response = $response->addHeader('X-frame-options', 'DENY');

### Sending
emitResponseToSApi($response);
