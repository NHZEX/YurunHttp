<?php

return [
    'configs'    =>    [
    ],
    // bean扫描目录
    'beanScan'    =>    [
        'WebSocket\MainServer\Controller',
    ],
    'beans'    =>    [
        'WebSocketDispatcher'    =>    [
            'middlewares'    =>    [
                \Imi\Server\WebSocket\Middleware\RouteMiddleware::class,
            ],
        ],
        'GroupRedis'    =>    [
            'redisPool'    =>    'redis',
        ],
        'HttpDispatcher'    =>    [
            'middlewares'    =>    [
                \Imi\Server\WebSocket\Middleware\HandShakeMiddleware::class,
                \Imi\Server\Http\Middleware\RouteMiddleware::class,
            ],
        ],
        'ConnectContextRedis'    =>    [
            'redisPool' =>    'redis',
            'lockId'    =>  'redis',
        ],
    ],
];