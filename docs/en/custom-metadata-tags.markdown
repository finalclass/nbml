# Custom Metadata tags [custom-metadata-tags]

The nbml engine makes possible to define which metadata tags should be concerned
when interpreting components. You make this choice when initialising compiler.
Go to section [Instantation][instantiation] to learn more
about this process.

Class `\Nbml\Compiler` has a method `->addTagProcessor($className)`
which allows to add custom tags. For instance initialisation of
metadata tags provided with standard library looks as follows:

	$viewCompiler = new Compiler();
	$viewCompiler
	      ->addTagProcessor('\Nbml\MetadataTag\PublicMetadataTag')
	      ->addTagProcessor('\Nbml\MetadataTag\StateMetadataTag')
	      ->addTagProcessor('\Nbml\MetadataTag\OnDemandMetadataTag')
	      ->addTagProcessor('\Nbml\MetadataTag\OnStateMetadataTag')
	      ->addTagProcessor('\Nbml\MetadataTag\CssMetadataTag')
	      ->addTagProcessor('\Nbml\MetadataTag\JsMetadataTag');

In order to create custom tag, you have to create a class that implements interface
`\Nbml\MetadataTag`:

	namespace Nbml;
	use \Nbml\Reflector\Variable;
	use \Nbml\Reflector\MetadataTagDefinition;
	use \Nbml\Reflector;

	interface MetadataTag
	{
	    static function getMetadataTagName();
	    function __construct(Variable $variable, MetadataTagDefinition $definition, Reflector $classReflection);
	    function hasGetter();
	    function getGetterMethodDefinition();
	    function hasSetter();
	    function getSetterMethodDefinition();
	    function hasInitializationCode();
	    function getInitializationCode();
	    function hasBeforeRenderRetrievalCode();
	    function getBeforeRenderRetrieveCode();
	    function getRequiredProperties();
	    function hasDefaultProperty();
	    function getDefaultPropertyName();
	}

Here comes to aid class `\Nbml\MetadataTag\AbstractMetadataTag` which implements
most of the methods of `\Nbml\MetadataTag` interface. It is recommended to extend this class
in purpose to create new tags' processors.

## Exemplary metadata tag

Let's assume that we want to build our own metadata tag `[Hello]`, which would add to variable which is assigned to 
the string: "Hello ". Here is this tag's content:

Content of such metadata tags' processor shall be as follows:

	<?php

	class HelloMetadataTag extends \Nbml\MetadataTag\AbstractMetadataTag
	{
	    static function getMetadataTagName()
	    {
	        return 'Hello';
	    }

	    public function getInitializationCode()
	    {
	        $nameUnderscored = $this->variable->getNameUnderscored();
	        $default = $this->variable->getDefaultValue();
	        return '$this->options[\'' . $nameUnderscored . '\'] = '
	            . '\'Hello \' . ' .  $default . ';';
	    }
	}

In order to use it, one has to add it to compiler in such way:

	$viewCompiler->addTagProcessor('\HelloMetadataTag')

From this now it is possible to use metadata tag `[Hello]`

**HelloComponent.nbml**

	<?php /**
	 * @var $this \Nbml\Component
	 *
	 * [Hello] @var $miwa string('Miwa')
	 */ ?>

	 <?=$miwa?>

Invoke of this component:

	<?php
	echo new HelloComponent(); //Hello Miwa

When writing components we have an access to variables `$this->variable` and `$this->definition`.
`$this->variable` is of `\Nbml\Reflector\Variable` type and has in itself full description 
of variable, which given metadata tag is assigned to.

On the other hand, variable `$this->definition`
is a definiton of given metadata tag (in this case a definition of meta tag Hello).
It is of type: \Nbml\Reflector\MetadataTagDefinition. In this object we'll find
all data concerning attributes (and its values) of given metadata tag.

Sometimes when building certain metadata tag a necessity can arise to manipulate the entire
being-built component's class. Here comes to aid the property `$this->classReflection`
which is of type `\Nbml\Reflector`.

Consider also this line in metadata tag `[Hello]` that is being built:

	return '$this->options[\'' . $nameUnderscored . '\'] = '
	            . '\'Hello \' . ' .  $default . ';';

You may wonder where one should know from how to write such line? Well it depends 
on you. It depends on you what your components would inherit from.
By default it is class `\Nbml\Component`, its knowledge is crucial here.
Let's have a look at its content:

	namespace Nbml;

	class Component
	{
	    protected $text = '';
	    protected $options = array();
	    public function __construct($options = array())
	    {
	        $this->options = array_merge($this->options, $options);
	    }

	    public function __toString()
	    {
	        try {
	            $this->__invoke();
	        } catch(\Exception $e) {
	            trigger_error((string)$e);
	        }
	        return $this->text;
	    }

	    public function __invoke()
	    {
	        return '';
	    }
	}

As it may be seen it is a very short, light class. Ready to being expanded.
Writing the components, the interpreter overrides function `__invoke()`. 
The role of the function __invoke()
is to fill up variable `$this->text`.

Whtat remains to me, is to left you with your imagination:)
