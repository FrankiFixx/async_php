<?php
use Swoole\WebSocket\Server;

// Create a WebSocket Server object and listen on 0.0.0.0:9502.
$ws = new Server('0.0.0.0', 9502);

$ws->on('start',function(Server $ws){
   echo 'server started on ws://127.0.0.1:9502'.PHP_EOL;
});
// Listen to the WebSocket connection open event.
$ws->on('Open', function ($ws, $request) {
    $ws->push($request->fd, "hello, welcome\n");
});

// Listen to the WebSocket message event.
$ws->on('Message', function ($ws, $frame) {
    echo "Message: {$frame->data}\n";
    $ws->push($frame->fd, "server: {$frame->data}");
});

// Listen to the WebSocket connection close event.
$ws->on('Close', function ($ws, $fd) {
    echo "client-{$fd} is closed\n";
});

$ws->start();