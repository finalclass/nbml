# Instantiation using Composer (recommended method) [instantiation-composer]

Nbml can be also found in packagist, what makes using composer much simpler.
I will show how we can make use of composer to establish a new project.

Let us assume, that we have following structure of folders / files:

* public

	* index.php
* src

	* MyNamespace
* tmp
* composer.json
* composer.phar

The content of our **composer.json** file should be as follows:

	{
		"require":{
			"php":">=5.3.0",
			"finalclass/nbml":"dev-master"
		},
		"autoload":{
			"psr-0":{
				"MyNamespace": "src/"
			}
		}
	}

where MyNamespace is your namespace - any custom string.
Notice block require: `"finalclass/nbml":"dev-master"` - I assume using the development version
of nbml package here. It is not recommended solution - type here the version that fits you the most.

When we create and save this file, it's needed to run script composer.phar at folder where the project is being created, in this way:

	php composer.phar install

This script will create vendor folder, and fill it up with dependencies.
At this moment ViewAutoLoader should be initialised.

Content of the file **index.php**

	$autoLoader = include '../vendor/autoload.php';
	$viewAutoLoader = include '../src/init_view_auto_loader.php';

As can be seen, the autoloader file included by composer, was added. Through this there is no need to
create ClassAutoLoader instance provided by nbml.

In index.php there is also included file init_view_auto_loader.php, whitch has to be written by you.
Below can be found the exemplary content:

Content of file **/src/init_view_auto_loader.php**:

	<?php

	use \Nbml\AutoLoader\ViewAutoLoader;
	use \Nbml\Compiler;

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
				->addTagProcessor('\Nbml\MetadataTag\JsMetadataTag');

	$viewAutoLoader->setViewCompiler($viewCompiler);

	return $viewAutoLoader;

It is identical file as in case of manual instantiation [instantiation-manual] with the exception, that there is no
creating a ClassAutoLoader instance here.
