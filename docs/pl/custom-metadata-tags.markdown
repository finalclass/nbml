# Custom Metadata tags [custom-metadata-tags]

The nbml engine makes possible to define which metadata tags should be concerned
when interpreting components. You make this choice when initialising compiler.
Go to section [Tworzenie instancji][instantiation] to learn more
about this process.

Class `\Nbml\Compiler` has a method `->addTagProcessor($className)`
which allows adding custom tags. For instance initialisation of
Metadata tags included with standard library looks as follows:

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

## Exemplary Metadata tag

Let's assume, that we want to build our own metadata tag `[Hello]` which would add to variable which is assigned to 
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

Writing components we have an access 
Pisząc komponenty mamy dostęp dozmiennej `$this->variable` oraz `$this->definition`.
Zmienna `$this->variable` jest typu `\Nbml\Reflector\Variable` i jest w niej pełen opis
zmiennej do kórej dany metadata tag jest przypisany.

Natomiast zmienna `$this->definition`
jest definicją danego metadata tagu (w tym przypadku definicją meta tagu Hello).
Jest ona typu: \Nbml\Reflector\MetadataTagDefinition. W tym obiekcie znajdziemy
wszystkie dane o atrybutach (i ich wartościach) danego metadata tagu

Czasem budując pewien metadata tag może powstać konieczność ingerencji w całą
budowaną klasę komponentu. Z pomocą przychodzi nam właściwość `$this->classReflection`
która to jest typu `\Nbml\Reflector`.

Zwróć jeszcze uwagę na tę linię budowanego metadata tagu `[Hello]`:

	return '$this->options[\'' . $nameUnderscored . '\'] = '
	            . '\'Hello \' . ' .  $default . ';';

Możesz się zastanawiać skąd wiadomo w jaki sposób taką linię napisać? Otóż to zależy
od ciebie. Od ciebie zależy po czym twoje komponenty będą dziedziczyć.
Domyślnie jest to klasa `\Nbml\Component`, jej znajomośc jest tutaj kluczowa.
Rzućmy okiem na jej treść:

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

Jak widać jest to bardzo krótka, lekka klasa. Gotowa do rozbudowywania.
Pisząc komponenty interpreter nadpisuje funkcję `__invoke()`. Rolą funkcji __invoke()
jest zapełnienie zmiennej `$this->text`

Pozostaje mi już tylko pozostawić ciebie twojej wyobraźni:)
