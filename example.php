<?php

use Spiral\RoadRunner\Http\PSR7Worker;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;
use Spiral\Goridge\StreamRelay;
use Spiral\RoadRunner\Worker;

require __DIR__ . '/vendor/autoload.php';

$relay = new StreamRelay(STDIN, STDOUT);
$worker = new Worker($relay);
$psrFactory = new Psr17Factory();
$creator = new ServerRequestCreator(
    $psrFactory,
    $psrFactory,
    $psrFactory,
    $psrFactory
);

// Создаем PSR-7 Worker для обработки HTTP-запросов
$psr7Worker = new PSR7Worker($worker, $creator);

while ($req = $psr7Worker->waitRequest()) {
    try {
        // Обрабатываем HTTP-запрос и возвращаем HTTP-ответ
        $response = $psrFactory
            ->createResponse(200)
            ->withBody($psrFactory->createStream('Hello, RoadRunner!'));

        $psr7Worker->respond($response);
    } catch (\Throwable $e) {
        $psr7Worker->respond($psrFactory->createResponse(500, 'Internal Server Error'));
    }
}
