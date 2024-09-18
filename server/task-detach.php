<?php

/** @noinspection ALL */

use Swoole\Http\Request;
use Swoole\Http\Response;
use Swoole\HTTP\Server;

include_once './vendor/autoload.php';

$server = new Server("0.0.0.0", 9501);

$var = [];

$server->set([
    'worker_num' => 8,       // Количество основных рабочих процессов (воркеров)
    'task_worker_num' => 8,  // Количество процессов для задач
]);

$server->on('request', function (Request $request, Response $response) use ($server) {
    // Передаем задачу в пул задач
    $data = "This is a task";

    $response->detach();
    $taskId = $server->task(['fdId' => $response->fd, 'data' => $request->getContent()]); // Отправляем задачу в пул
});

$server->on('finish', function (Swoole\Server $server, int $taskId, mixed $data) {
    echo "Таска task_id=$taskId завершена\n data=$data\n";
});

$server->on('task', function (Server $server, int $taskId, int $fromWorkerId, mixed $data) {
    $requestContent = $data['data'];
    $fdId = $data['fdId'];
    $resp = Swoole\Http\Response::create($fdId);
    echo "Начато выполнение задачи: id={$taskId}, data={$data}\n";
    sleep(2);
    $resp->end('content');
    echo "async task\n";
});


$server->on('start', function (Server $server) {
    echo "Swoole http server is started at http://127.0.0.1:9501\n";
});

$server->on("shutdown", function (Server $server) {
    echo "Swoole HTTP Server is shutting down...\n";
    // Очистка ресурсов и завершение работы
});

$server->start();

