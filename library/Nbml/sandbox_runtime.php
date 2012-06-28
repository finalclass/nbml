<?php

use \Nbml\AutoLoader\ClassAutoLoader;
use \Nbml\AutoLoader\ViewAutoLoader;
use \Nbml\Compiler;

require_once __DIR__ . '/AutoLoader/ViewAutoLoader.php';
require_once __DIR__ . '/AutoLoader/ClassAutoLoader.php';

$classAutoLoader = new ClassAutoLoader();
$classAutoLoader
        ->addIncludePath(__DIR__ . '/../')
        ->register();

$viewAutoLoader = new ViewAutoLoader();
$viewAutoLoader
		->addIncludePath(__DIR__ . '/../')
		->register();

$viewCompiler = new Compiler();
$viewCompiler
        ->addTagProcessor('\Nbml\MetadataTag\PublicMetadataTag')
        ->addTagProcessor('\Nbml\MetadataTag\StateMetadataTag')
        ->addTagProcessor('\Nbml\MetadataTag\OnDemandMetadataTag')
        ->addTagProcessor('\Nbml\MetadataTag\OnStateMetadataTag');

$viewAutoLoader->setViewCompiler($viewCompiler)
    ->setAlwaysCompile(true);

return $viewAutoLoader;