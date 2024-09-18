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
    $response->header('Content-Disposition', 'attachment; filename=file-to-send.txt');
    $response->sendfile('./files/file-to-send.txt');
});

$server->start();

