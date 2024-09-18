<?php
/** @noinspection ALL */

use Swoole\Coroutine;
use function Swoole\Coroutine\run;

echo "main start\n"; // Главный старт

// функция run создает runner
run(function () {
    echo "coro " . Coroutine::getcid() . " start\n"; // выводим id коррутины, id = 1
    Coroutine::create(function () {
        echo "coro " . Coroutine::getcid() . " start\n"; // выводим id коррутины, id = 2
        Coroutine::sleep(.2);
        echo "coro " . Coroutine::getcid() . " end\n"; // эта выводится предпослнедней, т.к 200 мс задержка
    });
    echo "coro " . Coroutine::getcid() . " do not wait children coroutine\n"; // выводим id коррутины, id = 1
    Coroutine::sleep(.1);
    echo "coro " . Coroutine::getcid() . " end\n"; // т.к задержка 100 мс, а в дочерней 200 то эта строчка выведется раньше
});

echo "Main end\n";