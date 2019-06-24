<?php
require __DIR__ . '/Args.php';

Args::init();
$nproc = Args::get('nproc');
$versionName = Args::get('-version-name');

if(version_compare(PHP_VERSION, '7.0', '>='))
{
    `wget https://github.com/swoole/swoole-src/archive/v4.4.0-beta.tar.gz -O swoole.tar.gz && mkdir -p swoole && tar -xf swoole.tar.gz -C swoole --strip-components=1 && rm swoole.tar.gz && cd swoole && phpize && ./configure && make -j${$nproc} && make install && cd -`;

    `echo "extension = swoole.so" >> ~/.phpenv/versions/{$versionName}/etc/php.ini`;
}
