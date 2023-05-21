<?php

declare(strict_types=1);

// todo test for detectLang
$request = createServerRequestFromGlobals(query: $_GET);
$name = ((string)$request->query['name']) ?: 'guest';
$name = htmlspecialchars($name);
$lang = detectLang('en', $request);

http_response_code(201);
header('X-frame-options: deny');

echo "<h1>Hello,$name</h1><div>Lang is $lang</div>";
