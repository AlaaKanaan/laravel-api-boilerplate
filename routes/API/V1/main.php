<?php

use LaravelJsonApi\Laravel\Facades\JsonApiRoute;

JsonApiRoute::server('v1')
    ->namespace('App\Http\Controllers\Api\V1')
    ->resources(function ($server) {
        $server->resource('users')
            ->parameter('id');
    });
