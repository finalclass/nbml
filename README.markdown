# NetBricks Markup Language [welcome]

Nbml is a language which serves to define views in object-oriented manner. With its help we can easily transform view in phtml format (HTML with insertions in PHP language), to PHP classes.



# System requirements [system-requirements]

The nbml library requires PHP in version minimum 5.3


# Instantiation [instantiation]

In order to start working with nbml files, one has to initialise ViewAutoLoader. This class registers php autoloader,
so it can handle *.nbml file. It can be done using provided sandbox, or
manually.
It is also needed to initialise some autoloader to nbml library classes - because nbml uses standard method to load classes this action is left to the programmer. But at first lets' go to the easier 
variant - to start work using sandbox file [instantiation-sandbox].


## Instantiation using sandbox [instantiation-sandbox]

It is the simplest, and at the same time the least flexible method to initialise nbml.

	$viewAutoLoader = include 'library/Nbml/sandbox_runtime.php';


## Creating an instance manually [instatiation-manual]

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
Standard [metadata tags][metadata-tags] are included. On this place you can include your own tags, or disable
unused ones to improve code clarity.


## Instantiation using Composer (recommended method) [instantiation-composer]

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


# Why should I use the nbml? [why-should-i-use-it]

PHP is a language, that is itself a system of templates. Writing websites 
utilizing pure html+js+css is the best solution. The problem is, that if you separate view from controller in PHP, the views are not precise, that means it's unknown what variables can the template accept. IDE is not able to prompt, what can be executed in given template. The coder doesn't know, what variables have been left to him by programmer.

Here the nbml comes to aid. Thanks to him we are still creating templates in HTML+PHP, but this time the contract between 
coder and programmer is clear. The coder knows what does he have in particular view, and the programmer is happy because he
has an object:) Nobody will ever confuse variables names, because IDE without problems parses
generated classes
and prompts available options and variables' types.

Thanks to this solution you get full **objected view**. You create a tree of light components. But you create it in HTML - so applying skins is trivial.
This solution is completely non-invasive and you can without any counter-indications use 
nbml, parallel
with other libraries.


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




# Metadata Tags [metadata-tags]

The nbml uses phpdoc for objects definitions. For example such construction:

	<?php /**
	 * @var $this \Nbml\Component
	 * @var $message string
	 */ ?>

will create a class that inherits from `\Nbml\Component` with private variable $message that has type `string`.
This way we can define certain aspects of component that is being built.
Nbml also has a mechanism to define custom tags, which change properties of defined variable.
In standard library we have at our disposal following tags: [\[Public\]][metadata-tags-public],
[\[State\]][metadata-tags-state], [\[OnState\]][metadata-tags-on-state],
[\[OnDemand\]][metadata-tags-on-demand], [\[Css\]][metadata-tags-css] and [\[Js\]][metadata-tags-js].

### Metadata tags attributes

Metadata tags can have certain attributes. If given Metatag has attributes, it can also have the default attribute defined. For instance attribute [\[State\]][metadata-tags-state] can 
be parametrised by `name` attribute, which is the default one. So this notation:

	* [OnState(name='selected')]

is equal with this notation:

	* [OnState('selected')]

In case when metadata tag accepts more attributes, their names should be separated with comma in such manner:

	* [Tag(attr1='value1', attr2='value2', attr3='value3')]

The interpreter also allows to easily create custom Metadata tags.
The process is described in this place [Custom Metadata Tags][custom-metadata-tags]


## Metadata Tags - Public [metadata-tags-public]

Let's consider following example:

**file HelloWorld.nbml**

	<?php /**
	 * @var $this \Nbml\Component
	 *
	 * [Public] @var $message string('Hello World!')
	 */ ?>
	 <div class="center bold">
	  <?=$message?>
	 </div>

And then its usage:

	<?php
	$helloComponent = new HelloWorld();
	echo $helloComponent->message(); //Hello World!
	$helloComponent->message('Hello Internet!');
	echo $helloComponent->message(); //Hello Internet!
	echo $helloComponent; //<div class..../>

Using of the Metadata tag \[Public\] shall cause creating a public getter and setter for private variable $message.


## Metadata Tags - State [metadata-tags-state]

Metadata tag [\[State\]][metadata-tags-state] causes adding a state to given component. Variables defined as [\[State\]][metadata-tags-state] should be boolean.
Enabling one state will cause disabling other ones.

Let us consider following exemplary button component:

**Button.nbml**

	<?php /**
	 * @var $this \Nbml\Component
	 *
	 * [State] @var $normalState boolean(true)
	 * [State] @var $selectedState boolean(false)
	 */ ?>

	 <a href="/example" label="Example" class="<?=$selectedState ? 'selected' : ''?>">
	 Example
	 </a>

and then its usage:

	<?php

	$button = new Button();
	var_dump($button->normalState()); //true
	$button->selectedState(true);
	var_dump($button->normalState()); //false
	echo $button;

Setting a variable selectedState on true, will cause other state's variables to be set on false.
One often uses metatag [\[State\]][metadata-tags-state] in collaboration with metatag [\[OnState\]][metadata-tags-on-state]


## Metadata Tags - OnState [metadata-tags-on-state]

Setting on a particular component the metatag [\[OnState\]][metadata-tags-on-state] will sets a condition on a particular variable.
**The variable will be initialised only in case, when the component finds itself in a given state.**
In other case its value will be an empty string.

Metadata tag [\[OnState\]][metadata-tags-on-state]
accepts one argument `name` defining the name of state, in which given variable has to initialise. The argument `name` is a default argument, so there is no need to write `[OnState(name='stateName')]`,one can use the shortened form: `[OnState('stateName')]`.

Let us consider a Button case:

**Button.nbml**

	<?php /**
	 * @var $this \Nbml\Component
	 *
	 * [State] @var $normalState boolean(true)
	 * [State] @var $selectedState boolean(false)
	 *
	 * [OnState('selectedState')] @var $selectedClass string('selected')
	 */ ?>
	 <a href="/example"
	    title="Example"
	    class="<?=$selectedClass?>">
	    Example
   </a>

This button will possess class `selected` **only** in case when the component Button will be in state selectedState.
This property can be easily connected with [\[Public\]][metadata-tags-public] to create customisable button in this manner:

	<?php /**
	 * @var $this \Nbml\Component
	 *
	 * [State] @var $normalState boolean(true)
	 * [State] @var $selectedState boolean(false)
	 *
	 * [OnState('selectedState')]
	 * [Public]
	 * @var $selectedClass string('selected')
	 *
	 * [Public] @var $href string('#')
	 * [Public] @var $label string
	 */ ?>
	<a href="<?=$href?>"
	   title="<?=$label?>"
	   class="<?=$selectedClass?>">
	    <?=$label?>
	</a>

In this case we can define by our own, what class should be used for state `selectedState`.


## Metadata Tags - OnDemand [metadata-tags-on-demand]

This tag causes creating in lieu of given variable the object `\Nbml\MetadataTag\OnDemandMetadataTag\OnDemandFactory`.
The foregoing class creates given variable in the very moment it's used
(in the moment methods `__toString()`, `__invoke()`,
`__call()`, `__set()` lub `__get()` are called).

	<?php /**
	 * @var $this \Nbml\Component
	 *
	 * [OnDemand]
	 * @var $subComponent \Nbml\Component
	 */ ?>

	 <div class="example">
	  <?php if(rand(0, 9) > 4): ?>
	    <?=$subComponent?>
	  <?php endif; ?>
	 </div>

In preceding example, in place of $subComponent the OnDemandFactory class is created, and then (only if rand(0, 9) > 4), OnDemand Factory in a very moment of invoking __toString() creates an object of class \Nbml\Component, as it was set in phpDoc.

The above example's purpose is to present the idea of the \[OnDemand\] tag functionality, however in real applications the tag is useless in this case. \[OnDemand\] shows its best at "heavy" components, whose initialisation involves heavy system's load.


## Metadata Tags - Css [metadata-tags-css]

Metadata tag [\[Css\]][metadata-tags-css] is used to load CSS files.
The nbml provides basic
version of the component, which actually is an HTML `\Nbml\Component\Application`.
This version can be extended with your own needs. Take notice that nmbl does not allow to put css and js files manually (it can be done, but is not recommended). Instead, it is recommended to create main component such way, that it can inherit from `\Nbml\Component\Application`. The Application component has variable styleSheets which is of type `\Nbml\Collection`. The style files can be added to it for example in this manner:

	\Nbml\Component\Application::getInstance()->styleSheets()->add('/css/styles.css')

Exactly this operation is done by tag [\[Css\]][metadata-tags-css]. Inasmuch `Application::getInstance()` returns always the last created instance (with `new`), in the moment of creating we have access exactly to it. In the system there shouldn't be created another instance of Application. We send to client just one HTML site!
Sure, there can be exceptions (but it's hard to me to figure out any).
In such case it should be kept in mind, that `Application::getInstance()`
always returns the last created instance.

### Attributes

Tag [\[Css\]][metadata-tags-css] has one attribute: file.
It is default attribute, so construction `[Css(file="/css/styles.css")]`
is equal with `[Css("/css/styles.css")]`

### Relative paths

Tag [\[Css\]][metadata-tags-css] allows inputting relative paths.
When, for example, we create file providing relative path to CSS file:

**public/Example/MyComponent/MyComponent.nbml**

	<?php /**
	 * [Css('myComponent.css')]
	 * @var $this \Nbml\Component
	 */ ?>
	Component content...

the relative path shall be expanded this way:
`<link href="/Example/MyComponent/myComponent.css" .../>`

When we will define path as an absolute path: `[Css('/myComponent.css')]`
it remains unchanged: `<link href="/myComponent.css" .../>`.

In case of working with remote files, keep in mind that HTTP or HTTPS must be inserted when defining a location of CSS file - the system has to know, that it's dealing with remote file.
For instance a path: `[Css('example.com/file.css')]` used in aforementioned component will be extracted to: `/Example/MyComponent/example.com/file.css.`
The proper way to do this is to put __http__ on the beginning, in such manner:
`[Css('http://example.com/file.css')]`

The same rule applies to tag [\[Js\]][metadata-tags-js]

### Assigning tag to variable

The tag is not binded with the variable it is assigned to, however it should be assigned to some particular variable.

Below is wrong construcion:

**Wrong file!!!**

	<?php /**
	 * @var $this \Nbml\Component\Application
	 *
	 * [Css('/css/styles.css')]
	 */ ?>
	 Component content...

Properly this component should be built like this:

	<?php /**
	 * [Css('/css/styles.css')]
	 * @var $this \Nbml\Component\Application
	 */ ?>
	 Component content...

It means that tag [\[Css\]][metadata-tags-css] should be assigned to some particular variable.
The best way is to assign such metadata tags to variable $this. It is the recommended method.
Similarly works tag [\[Js\]][metadata-tags-js].


## Metadata Tags - Js [metadata-tags-js]

Functionality of [\[Js\]][metadata-tags-js] tag is identical with functionality of [\[Css\]][metadata-tags-css] tag with the exception, that it is responsible for adding JavaScript files.
It causes adding the following line in component's constructor:

	\Nbml\Component\Application::getInstance()->scripts()->add('file.js');



# Custom Metadata tags [custom-metadata-tags]


