## Composer (polecana metoda) [instantiation-composer]

Nbml może być znaleziony również w packagist co czyni korzystanie z composera o wiele prostszym.
Zaprezentuję w jaki sposób możemy skorzystać z composera do założenia nowego projektu.

Załóżmy, że posiadamy taką strukturę katalogów / plików:

* public

	* index.php
* src

	* MyNamespace
* tmp
* composer.json
* composer.phar

Treść naszego pliku **composer.json** powinna wyglądać następująco:

	{
		"require":{
			"php":">=5.3.0",
			"finalclass/nbml":"dev-master",
		},
		"autoload":{
			"psr-0":{
				"MyNamespace": "src/"
			}
		}
	}

gdzie MyNamespace jest twoją przestrzenią nazw - dowolnym łańcuchem znaków.
Zwróć uwagę na blok require: `"finalclass/nbml":"dev-master",` - zakładam tutaj użycie wersji developerskiej
pakietu nbml. Nie jest to zalecane rozwiązanie - wprowadź tutaj wersję najbardziej ci odpowiadającą.
Gdy utworzymy i zapiszemy ten plik, należy uruchomić skrypt composer.phar będąc w katalogu
z tworzonym projektem, w ten sposób:

	php composer.phar install

Skrypt ten utworzy folder vendor oraz zapełni go zależnościami.
W tym momencie należy zainicjalizować ViewAutoLoader.

Treść pliku **index.php**

	use \NbmlHome\View\Layout;

	$autoLoader = include '../vendor/autoload.php';
	$viewAutoLoader = include '../src/init_view_auto_loader.php';

Jak widać jest tutaj zaincludowany plik autoloadera dołączony przez composer. Dzięki temu nie ma konieczności
tworzenia instancji ClassAutoLoader dostarczonej przez Nbml.
W index.php jest również includowany plik init_view_auto_loader.php którego treść jest następująca:

Treść pliku **/src/init_view_auto_loader.php**

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

Jest to identyczny plik jak w przypadku instalacji manualnej [instantiation-manual] z tym, że nie ma tutaj
tworzenia instancji ClassAutoLoader.
