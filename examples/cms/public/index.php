<?php
 
use \Nbml\AutoLoader\ClassAutoLoader;
use \Nbml\AutoLoader\ViewAutoLoader;
use \Nbml\Compiler;
use \NetBricks\SimpleCms\Di;

session_start();

if(!defined('LIBRARY_PATH'))
        define('NBML_LIBRARY_DIR', realpath(__DIR__ . '/../../../library'));

require_once NBML_LIBRARY_DIR . '/Nbml/AutoLoader/ViewAutoLoader.php';
require_once NBML_LIBRARY_DIR . '/Nbml/AutoLoader/ClassAutoLoader.php';

initialize_autoloaders:
{
    $classAutoLoader = new ClassAutoLoader();
    $classAutoLoader
                    ->addIncludePath(NBML_LIBRARY_DIR)
                    ->addIncludePath(__DIR__ . '/../src')
                    ->register();

    $viewAutoLoader = new ViewAutoLoader();
    $viewAutoLoader
                    ->setCompilerDefaultDestinationDir(__DIR__ . '/../tmp')
                    ->setAlwaysCompile(true)
                    ->addIncludePath(__DIR__ . '/../src')
                    ->register();

    $viewCompiler = new Compiler();
    $viewCompiler
          ->addTagProcessor('\Nbml\MetadataTag\PublicMetadataTag')
          ->addTagProcessor('\Nbml\MetadataTag\StateMetadataTag')
          ->addTagProcessor('\Nbml\MetadataTag\OnDemandMetadataTag')
          ->addTagProcessor('\Nbml\MetadataTag\OnStateMetadataTag')
          ->addTagProcessor('\Nbml\MetadataTag\CssMetadataTag')
          ->addTagProcessor('\Nbml\MetadataTag\JsMetadataTag')
          //Custom:
          ->addTagProcessor('\NetBricks\SimpleCms\AdminAccessMetadataTag');

    $viewAutoLoader->setViewCompiler($viewCompiler);
}

Di::sqLiteFilePath(realpath(__DIR__ . '/../var/') . '/base.db');
Di::secretFilePath(realpath(__DIR__ . '/../var/') . '/secret');

\NetBricks\SimpleCms\Model\Article::initDb();

echo new NetBricks\SimpleCms\View\Application();
