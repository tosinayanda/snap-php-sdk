<?php
// DIC configuration

$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

$container['Validator'] = function () { 
    return new \myApp\Validator();
};

$container['AuditablesLogger'] = function () { 
    return new \myApp\AuditablesLogger();
};

$container['AuthorizationController'] = function ($c) { 
    return new \myApp\Controllers\AuthorizationController($c);
};

$container['UserController'] = function ($c) { 
    return new \myApp\Controllers\UserController($c);
};

$container['CustomerController'] = function ($c) { 
    return new \myApp\Controllers\CustomerController($c);
};

$container['AccountController'] = function ($c) { 
    return new \myApp\Controllers\AccountController($c);
};

$container['FundsTransferController'] = function ($c) { 
    return new \myApp\Controllers\FundsTransferController($c);
};

$container['MoneyMarketController'] = function ($c) { 
    return new \myApp\Controllers\MoneyMarketController($c);
};

$container['BulkUploadController'] = function ($c) { 
    return new \myApp\Controllers\BulkUploadController($c);
};
// PDO database library 
$container['db'] = function ($c) {
    $settings = $c->get('settings')['db'];
    $pdo = new PDO("mysql:host=" . $settings['host'] . ";dbname=" . $settings['dbname'],
        $settings['user'], $settings['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};
