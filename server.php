<?php

declare(strict_types = 1);

const ADDR = 'tcp://0.0.0.0:8083';

$socket = stream_socket_server(ADDR, $errno, $errstr);

if (!$socket) {
    die("$errstr ($errno)" . PHP_EOL);
}
echo "Server run on " . ADDR . PHP_EOL;

$env = getenv();
ksort($env);
$envs = print_r($env, true);

while ($connect = stream_socket_accept($socket, -1)) {
    $request = fread($connect, 100000);

    $response = <<<TEXT
HTTP/1.1 200 OK
Content-Type: text/plain; charset=UTF-8
Connection: close

Hello,World!

======REQUEST=====
$request
==============

======ENV=====
$envs
==============
TEXT;

    fwrite($connect, $response);
    fclose($connect);
}

fclose($socket);