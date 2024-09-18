<?php

namespace App\Controllers;

use Swoole\Http\Request;
use Swoole\Http\Response;

class Index
{
    public function index(Request $request, Response $response): void
    {
        $response->end('<h1>Hello I\'m index</h1>');
    }
}