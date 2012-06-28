<?php
use \Nbml\AutoLoader\ClassAutoLoader;
use \Nbml\Server;

require_once __DIR__ . '/AutoLoader/ClassAutoLoader.php';

$autoLoader = new \Nbml\AutoLoader\ClassAutoLoader();
$autoLoader->addIncludePath(__DIR__ . '/../')
    ->addIncludePath(__DIR__ . '/../tmp')
    ->register();

$server = new \Nbml\Server($_SERVER['REQUEST_URI'], array_merge($_GET, $_POST));
$server->config()
        ->includePath(__DIR__ . '/../')
        ->cacheDir(__DIR__ . '/../tmp')
        ->namespaces();

return $server;