<?php

namespace App;

use Swoole\Http\Request;
use Swoole\Http\Response;

class User
{
    public function index(Request $request, Response $response): void
    {
        $response->end("<h1> I'm user</h1>");
    }
}