<?php

use App\User;
use Swoole\Http\Request;
use Swoole\Http\Response;
use Swoole\HTTP\Server;
use App\Controllers\Index;

include_once './vendor/autoload.php';

$server = new Server("0.0.0.0", 9501);

$server->on('start', function (Server $server) {
    echo "Swoole http server is started at http://127.0.0.1:9501\n";
});

$server->on("shutdown", function (Server $server) {
    echo "Swoole HTTP Server is shutting down...\n";
});

$server->on('Request', function (Request $request, Response $response) {
    list($controller, $action) = explode('/', trim($request->server['request_uri'], '/'));

    if (empty($controller) || empty($action)) {
        $controller = Index::class;
        $action = 'index';
    }

    switch ($controller) {
        case 'index':
            $controller = Index::class;
            break;
        case 'user':
            $controller = User::class;
            break;
    }

    (new $controller)->$action($request, $response);
});

$server->start();
