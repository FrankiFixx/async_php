<?php
use Swoole\Http\Request;
use Swoole\Http\Response;
use Swoole\HTTP\Server;

$server = new Server("0.0.0.0", 9501);

$server->on('start', function (Server $server) {
    echo "Swoole http server is started at http://127.0.0.1:9501\n";
});

$server->on("shutdown", function (Server $server) {
    echo "Swoole HTTP Server is shutting down...\n";
});

$var = [];

$server->on("request", function (Request $request, Response $response)  use ($var){
    $response->end("<h1>Hello Swoole!</h1>");
});

$server->start();
