# Hello World example [hello-world-example]

As it is common, the first step in new language should be creating a program Hello World :)
The nbml obviously risen to the occasion, and presents you such a program.

I assume you have such folders' structure:

* library

  * Nbml
* public

	* HelloWorld

		* HelloWorld.nbml
	* index.php

We will use provided sandbox in order to initialize the intepreter.

file **index.php**

	<?php
	$viewAutoLoader = include '../library/Nbml/sandbox_runtime.php';
	echo new HelloWorld();

file **HelloWorld.nbml**

	<?php /**
	 * @var $this \Nbml\Component\Application
	 */ ?>
	Hello World!

It is all what needs to be encoded. Now what remains, is to run the script.
Your eyes will be presented with this WWW website, with following source code:

**Generated html**

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

Notice, that in folder HelloWorld has been created a new file: HelloWorld.php - it is compiled version of file 
HelloWorld.nbml. Here is its content:

**Generated php**

	<?php

	class HelloWorld extends \Nbml\Component\Application
	{

	    static public $DIR = 'D:\Dokumenty\nbml\strona_projektu\www\vendor\finalclass\nbml\examples\hello_world\HelloWorld\HelloWorld.nbml';

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


