<?php
return [
    // 项目根命名空间
    'namespace'    =>    'WebSocket',

    // 配置文件
    'configs'    =>    [
        'beans'        =>    __DIR__ . '/beans.php',
    ],

    // 扫描目录
    'beanScan'    =>    [
        'WebSocket\Listener',
    ],

    // 组件命名空间
    'components'    =>  [
    ],

    // 主服务器配置
    'mainServer'    =>    [
        'namespace'    =>    'WebSocket\MainServer',
        'type'        =>    Imi\Server\Type::WEBSOCKET,
        'host'        =>    '127.0.0.1',
        'port'        =>    8900,
        'configs'    =>    [
            'worker_num'    =>  1,
        ],
    ],

    // 子服务器（端口监听）配置
    'subServers'        =>    [
    ],

    // 连接池配置
    'pools'    =>    [
        'redis'    =>    [
            'sync'    =>    [
                'pool'    =>    [
                    'class'        =>    \Imi\Redis\SyncRedisPool::class,
                    'config'    =>    [
                        'maxResources'    =>    10,
                        'minResources'    =>    0,
                    ],
                ],
                'resource'    =>    [
                    'host'        => '127.0.0.1',
                    'port'        =>    6379,
                ]
            ],
            'async'    =>    [
                'pool'    =>    [
                    'class'        =>    \Imi\Redis\CoroutineRedisPool::class,
                    'config'    =>    [
                        'maxResources'    =>    10,
                        'minResources'    =>    0,
                    ],
                ],
                'resource'    =>    [
                    'host'        => '127.0.0.1',
                    'port'        =>    6379,
                ]
            ],
        ],
    ],

    // redis 配置
    'redis' =>  [
        // 数默认连接池名
        'defaultPool'   =>  'redis',
    ],

    // 锁
    'lock'  =>[
        'list'  =>  [
            'redis' =>  [
                'class' =>  'RedisLock',
                'options'   =>  [
                    'poolName'  =>  'redis',
                ],
            ],
        ],
    ],
];