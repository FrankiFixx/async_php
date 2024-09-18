<?php

use Swoole\Http\Request;
use Swoole\Http\Response;
use Swoole\HTTP\Server;

include_once './vendor/autoload.php';

$server = new Server("0.0.0.0", 9501);

$var = [];
$server->on('start', function (Server $server) {
    echo "Swoole http server is started at http://127.0.0.1:9501\n";
});

$server->on("shutdown", function (Server $server) {
    echo "Swoole HTTP Server is shutting down...\n";
    // Очистка ресурсов и завершение работы
});

$server->on('Request', function (Request $request, Response $response) {
    $response->write("Hello, this is the first part of the response.\n");

    Swoole\Timer::after(1000, function () use ($response) {
        $response->write("This is the second part, sent after 1 second.\n");
        $response->end("Final part of the response, closing connection.\n");
    });
});

$server->start();

