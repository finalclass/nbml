# Creating an instance manually [instatiation-manual]

We can, of course, initialise the interpreter manually. Thanks to this we can at its fullest have benefit from the configuration options, which are provided by the interpreter.
Below you can find an exemplary manual configuration:

**file index.php**

	<?php

	use \Nbml\AutoLoader\ClassAutoLoader;
	use \Nbml\AutoLoader\ViewAutoLoader;
	use \Nbml\Compiler;

	require_once __DIR__ . '/AutoLoader/ViewAutoLoader.php';
	require_once __DIR__ . '/AutoLoader/ClassAutoLoader.php';

	$classAutoLoader = new ClassAutoLoader();
	$classAutoLoader
					->addIncludePath(__DIR__ . '/../library')
					->register();

	$viewAutoLoader = new ViewAutoLoader();
	$viewAutoLoader
					->setCompilerDefaultDestinationDir(__DIR__ . '/../tmp')
					->setAlwaysCompile(true)
					->addIncludePath(__DIR__ . '/../library')
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

The installer assumes, that you have following folders structure:

* public

	* index.php
* library

	* Nbml
* tmp

And now step by step. We include files of Autoloaders classes (ViewAutoLoader and ClassAutoLoader).
Then we should initialise ClassAutoLoader in order to properly load nbml compiler's classes.

	$classAutoLoader = new ClassAutoLoader();
	$classAutoLoader
			->addIncludePath(__DIR__ . '/../library')
			->register();

Hence we can without worries initialise autoloader to the *.nbml classes

	$viewAutoLoader = new ViewAutoLoader();
	$viewAutoLoader
			->setCompilerDefaultDestinationDir(__DIR__ . '/../tmp')
			->setAlwaysCompile(true)
			->addIncludePath(__DIR__ . '/../library')
			->register();

The foregoing script assumes, that *.nbml files are located in library folder, and also that after compilation they would be placed
in tmp folder. Make sure www server has privileges to write to this folder.
The Autoloader is set, that regardless of whether file was changed or not, it will be
compiled each time the autoloader is invoked. It consumes so much time, 
that in production environment this option
should be turned off. When the option setAlwaysCompile is set to false, the compiler will be run **only** in case
when the time of last change of *.nbml file is greater than time of last change of generated *.php file.

Then, what remains, is creating a compiler instance and adding it to autoloader.

	$viewCompiler = new Compiler();
	$viewCompiler
        ->addTagProcessor('\Nbml\MetadataTag\PublicMetadataTag')
        ->addTagProcessor('\Nbml\MetadataTag\StateMetadataTag')
        ...
	$viewAutoLoader->setViewCompiler($viewCompiler);

This operation is separated from ViewAutoLoader in purpose to allow more customisation - you can create your own compiler,
or extend the existing one completely as you wish.
Standard metadata-tags [metadata-tags] are included. On this place you can include your own tags, or disable
unused ones to improve code clarity.
