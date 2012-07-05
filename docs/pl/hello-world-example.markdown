# Hello World example [hello-world-example]

Jak to zostało przyjęte, pierwszym krokiem w nowym języku powinno być utworzenie programu Hello World:)
nbml oczywiście stanął na wysokości zadania i takowy program wam prezentuje.

Zakładam taką strukturę katalogów:

* library

	* Nbml
* public

	* HelloWorld

		* HelloWorld.nbml
	* index.php

Skorzystamy z dostarczonego sandboxa w celu zainicjalizowania interpretera.

plik **index.php**

	<?php
	$viewAutoLoader = include '../library/Nbml/sandbox_runtime.php';
	echo new HelloWorld();

plik **HelloWorld.nbml**

	<?php /**
	 * @var $this \Nbml\Component\Application
	 */ ?>
	Hello World!

To wszystko co należy zakodować. Teraz postaje uruchomić skrypt.
Twoim oczom ukaże się strona www o takim kodzie źródłowym:

**wygenerowany html**

	<!DOCTYPE>
	<html>
	<head>
	    <title></title>
	    <meta charset="utf-8"/>
	    <META http-equiv="Content-Type" content="text/html; charset=utf-8">
	</head>
	<body>
	Hello World!
	</body>
	</html>

Zwróć uwagę, że w folderze HelloWorld został utworzony nowy plik: HelloWorld.php - jest to skompilowana wersja
pliku HelloWorld.nbml. Oto treść tego pliku:

**wygenerowany php**

	<?php

	class HelloWorld extends \Nbml\Component\Application
	{

	    static public $PATH = '/var/www/hello_world/HelloWorld/HelloWorld.nbml';

	    /**
	     * @return \HelloWorld
	     */
	    static public function create()
	    {
	        return new \HelloWorld();
	    }

	    protected $options = array();

	    public function __construct($options = array())
	    {
	        parent::__construct($options);
	    }


	    /**
	     * @return \HelloWorld
	     */
	    public function __invoke()
	    {
	        ob_start();

	        ?><?php /**
	     * @var $this \Nbml\Component\Application
	     */
	        ?>

	    Hello World!
	    <?php
	        $this->text = ob_get_clean();
	        return $this;
	    }
	}


