<?php
/** @noinspection ALL */

use Swoole\Coroutine;
use function Swoole\Coroutine\run;

echo "main start\n"; // Главный старт

$cid = go(function () {
    echo "co 1 start\n";
    Co::yield();
    echo "co 1 end\n";
});

go(function () use ($cid) {
    echo "co 2 start\n";
    Co::sleep(0.5);
    Co::resume($cid);
    echo "co 2 end\n";
});

Swoole\Event::wait();

echo "Main end\n";