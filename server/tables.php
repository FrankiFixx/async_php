<?php
use Swoole\Http\Request;
use Swoole\Http\Response;
use Swoole\HTTP\Server;
use Swoole\Table;

$server = new Server("0.0.0.0", 9501);

$usersTable = new Table(1024);
$usersTable->column('id', Table::TYPE_INT);
$usersTable->column('name', Table::TYPE_STRING, 64);
$usersTable->column('balance', Table::TYPE_FLOAT);
$usersTable->create();

// Заполняем данными
$usersTable->set('user_1', ['id' => 1, 'name' => 'John', 'balance' => 100.50]);
$usersTable->set('user_2', ['id' => 2, 'name' => 'Alice', 'balance' => 200.75]);

$server->on('start', function (Server $server) {
    echo "Swoole http server is started at http://127.0.0.1:9501\n";
});

$server->on("shutdown", function (Server $server) {
    echo "Swoole HTTP Server is shutting down...\n";
});

$var = [];

$server->on("request", function (Request $request, Response $response)  use ($var, $usersTable){
    $usersTable->set('user', ['id' => 3, 'name' => 'Alice', 'balance' => 200.75]);
    $user = $usersTable->get('user');
    $response->end(json_encode($user));
});

$server->start();
