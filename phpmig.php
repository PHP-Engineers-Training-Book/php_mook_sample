<?php
use \Phpmig\Adapter,
    \Phpmig\Pimple\Pimple,
    \Doctrine\DBAL\DriverManager;

$container = new Pimple();

$env = getenv('APP_ENV') ?: 'development';
$container['config'] = require __DIR__ . "/config/$env.php";

$container['db'] = $container->share(function($c) {
    print_r($c['config']['db']);
    return DriverManager::getConnection($c['config']['db']);
});

$container['phpmig.adapter'] = $container->share(function($container) {
    return new Adapter\Doctrine\DBAL($container['db'], 'migrations');
});

$container['phpmig.migrations'] = function() {
    return glob(__DIR__ . DIRECTORY_SEPARATOR . 'migrations/*.php');
};

return $container;
