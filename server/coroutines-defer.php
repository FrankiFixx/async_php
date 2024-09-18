<?php
/** @noinspection ALL */

use Swoole\Coroutine;
use function Swoole\Coroutine\run;

echo "main start\n"; // Главный старт

// функция run создает runner
run(function () {
    defer(function () {
        echo "coro " . Coroutine::getcid() . " defer\n";
    });
    echo "coro " . Coroutine::getcid() . " start\n"; // выводим id коррутины, id = 1

    for ($i = 0; $i < 10; $i++) {
        echo "coroutine" . $i;
    }

    go(function () {
        defer(function () {
            echo "coro " . Coroutine::getcid() . " defer\n";
        });

        echo "coro " . Coroutine::getcid() . " start\n"; // выводим id коррутины, id = 2

        go(function () {
            Coroutine::sleep(1);
            for ($i = 0; $i < 10; $i++) {
                echo "coroutine2" . $i;
            }
        });

        Coroutine::sleep(.2);
        echo "coro " . Coroutine::getcid() . " end\n"; // эта выводится предпослнедней, т.к 200 мс задержка
    });

    echo "coro " . Coroutine::getcid() . " do not wait children coroutine\n"; // выводим id коррутины, id = 1
    Coroutine::sleep(.1);
    echo "coro " . Coroutine::getcid() . " end\n"; // т.к задержка 100 мс, а в дочерней 200 то эта строчка выведется раньше

});

echo "Main end\n";