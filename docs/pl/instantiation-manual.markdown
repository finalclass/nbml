# Tworzenie instancji metodą manualną [instatiation-manual]

Możemy oczywiście zainicjalizować interpreter ręcznie. Dzięki temu możemy w pełni
skorzystać z opcji konfiguracyjnych jakie dostarcza nam interpreter.
Poniżej znajduje się przykładowa konfiguracja manualna.

**plik index.php**

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

Instalacja zakłada, że posiadasz taką strukturę katalogów:

* public

	* index.php
* library

	* Nbml
* tmp

A teraz po kolei. Załączami pliki klas Autoloaderów (ViewAutoLoader oraz ClassAutoLoader).
Następnie należy zainicjalizować ClassAutoLoader w celu poprawnego ładowania klas kompilatora Nbml.

	$classAutoLoader = new ClassAutoLoader();
	$classAutoLoader
			->addIncludePath(__DIR__ . '/../library')
			->register();

Teraz możemy bez obaw inicjalizować autoloader do klas *.nbml

	$viewAutoLoader = new ViewAutoLoader();
	$viewAutoLoader
			->setCompilerDefaultDestinationDir(__DIR__ . '/../tmp')
			->setAlwaysCompile(true)
			->addIncludePath(__DIR__ . '/../library')
			->register();

Powyższy skrypt zakłada, że pliki *.nbml znajdują się w folderze library, oraz że po kompilacji będą one umieszczane
w folderze tmp. Upewnij się, że serwer www ma uprawnienia do zapisu w tym folderze. Autoloader jest ustawiony w ten sposób, że niezależnie od tego czy plik był zmieniony czy nie, będzie
on kompilowany każdorazowo przy wywołaniu autoloadera. Jest to bardzo czasochłonne i w środowisku produkcyjnym należy
to wyłączyć. Gdy opcja setAlwaysCompile zostanie ustawiona na false, kompilator będzie uruchamiany **tylko** w przypadku
gdy czas ostatniej zmiany pliku *.nbml jest większy od czasu ostatniej zmiany wygenerowanego pliku *.php

Następnie pozostaje nam utworzenie instancji kompilatora i dodanie jej do autoloadera.

	$viewCompiler = new Compiler();
	$viewCompiler
        ->addTagProcessor('\Nbml\MetadataTag\PublicMetadataTag')
        ->addTagProcessor('\Nbml\MetadataTag\StateMetadataTag')
        ...
	$viewAutoLoader->setViewCompiler($viewCompiler);

Operacja ta jest odseparowana od ViewAutoLoader w celu większej customizacji - możesz utworzyć własny kompilator,
czy rozszerzyć istneiejący wedle uznania.
Dołączane są standardowe metadata tagi [metadata-tags]. W tym miejscu możesz załączyć własne, lub wyłączyć
nieużywane w celu poprawy czytelności kodu.
