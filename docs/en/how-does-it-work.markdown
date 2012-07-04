# How does it work? [how-does-it-work]

The idea that lies behind is quite simple. We create *.nbml files which are interpreted to *.php files. Specifically - to PHP classes.
*.nbml files are ordinary HTML files with PHP-code interwoven, that is they are standard files of PHP templates (these files often 
have an extension *.phtml). Then a class is created from them.
Schematically it can be shown this way:

Let us assume, that we have such *.nbml file:

	<?php /**
	 * @var $this \Nbml\Component
	 */ ?>
	 Example component

Let's put it in MyNamespace\Example folder and name it Example.nbml (the file would be in this location: /MyNamespace/Example/Example.nbml)

Now let's execute somewhere in *.php file following instruction:

	<?php
	$exampleComponent = new \MyNamespace\Example();
	echo $exampleComponent

In the moment of using class \MyNamespace\Example, a file MyNamespace/Example/Example.nbml shall be downloaded, compiled to class 
\MyNamespace\Example and included (require_once).


**Schematically** content of generated PHP file will be as following:

	<?php
	namespace MyNamespace;
	class Example extends \Nbml\Component
	{

	  public function __toString()
	  {
	    ?>
	    <?php /**
         * @var $this \Nbml\Component
         */ ?>
         Example component

     <?php
	  }
	}

Of course it is only an operating scheme, if you are interested in particular compilation,
simply check how file 
Example.php looks like in reality.
