<?php
/** @noinspection ALL */

use Swoole\Coroutine;
use function Swoole\Coroutine\run;

echo "main start\n"; // Главный старт

$id = go(function(){
    $id = Co::getuid();
    echo "start coro  $id\n";
    Co::suspend();
    echo "resume coro $id @1\n";
    Co::suspend();
    echo "resume coro  $id @2\n";
});

echo "start to resume $id @1\n";
Co::resume($id);
echo "start to resume $id @2\n";
Co::resume($id);
echo "main\n";


echo "Main end\n";
//Swoole\Event::wait();