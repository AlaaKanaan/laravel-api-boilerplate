<?php

use App\Models\User;
use LaravelJsonApi\Laravel\Facades\JsonApiRoute;
use LaravelJsonApi\Laravel\Routing\ActionRegistrar;

JsonApiRoute::server('v1')
    ->namespace('App\Http\Controllers\Api\V1')
    ->resources(function ($server) {
        $server->resource('users')
            ->parameter('id')
            ->actions(function (ActionRegistrar $actions) {
                $actions->get('me');
            });
    });
