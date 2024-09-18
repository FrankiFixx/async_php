<?php
/** @noinspection ALL */

use Swoole\Coroutine;
use function Swoole\Coroutine\batch;

Coroutine::set(['hook_flags' => SWOOLE_HOOK_ALL]);

$start_time = microtime(true);
$result = Coroutine\run(function () {
    $use = microtime(true);
    $results = batch([
        'file_put_contents' => function () {
            return  "file-put content\n";
        },
        'gethostbyname' => function () {
          return "hostname\n";
        },
        'file_get_contents' => function () {
            return "file_content\n";
        },
        'sleep' => function () {
            sleep(1);
            return true;
        },
        'usleep' => function () {
            usleep(1000);
            return true;
        },
    ], 0.1);
    $use = microtime(true) - $use;
    echo "Use {$use}s, Result:\n";
    var_dump($results);
});

var_dump($result);
$end_time =  microtime(true) - $start_time;
echo "Use {$end_time}s, Done\n";
