<?php
/** @noinspection ALL */

use Swoole\Coroutine;
use function Swoole\Coroutine\run;
use Swoole\Coroutine\Channel;

Co\run(function() {
    $chan = new Channel(2);  // Создаем канал с буфером на 2 элемента

    // Первая корутина
    go(function() use ($chan) {
        Coroutine::sleep(1); // Имитация работы
        $chan->push("Result 1"); // Отправляем результат
    });

    // Вторая корутина
    go(function() use ($chan) {
        Coroutine::sleep(2); // Имитация работы
        $chan->push("Result 2"); // Отправляем результат
    });

    // Получаем результаты из канала
    $result1 = $chan->pop();
    $result2 = $chan->pop();


    echo "Received results: {$result1}, {$result2}\n";
});
