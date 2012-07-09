# Custom Metadata tags [custom-metadata-tags]

Silnik nbml umożliwia definiowanie jakie metadata tagi mają być brane pod uwagę podczas interpretowania komponentów. Inicjalizując kompilator dokonujesz tego wyboru. Przejdź do sekcji Tworzenie instancji[Instantiation] aby zgłębić ten proces.

Klasa `\Nbml\Compiler` posiada metodę `->addTagProcessor($className)` która to umożliwia dodawanie własnych znaczników. Przykładowo inicjalizacja Metadata tagów dołączonych z biblioteką standardową wygląda w ten sposób:

	$viewCompiler = new Compiler();
	$viewCompiler
	      ->addTagProcessor('\Nbml\MetadataTag\PublicMetadataTag')
	      ->addTagProcessor('\Nbml\MetadataTag\StateMetadataTag')
	      ->addTagProcessor('\Nbml\MetadataTag\OnDemandMetadataTag')
	      ->addTagProcessor('\Nbml\MetadataTag\OnStateMetadataTag')
	      ->addTagProcessor('\Nbml\MetadataTag\CssMetadataTag')
	      ->addTagProcessor('\Nbml\MetadataTag\JsMetadataTag');

Aby stworzyć własny znacznik musisz stworzyć klasę implementującą interfejs
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

Z pomocą przychodzi klasa `\Nbml\MetadataTag\AbstractMetadataTag` która to implementuje większość metod interfejsu `\Nbml\MetadataTag`. Zaleca się rozszerzanie tej klasy w celu tworzenia nowych procesorów znaczników.

## Przykładowy Metadata tag

Załóżmy, że chcemy zbudować własny metadata tag `[Hello]` który to dodawałby do zmiennej do której jest przypisany, łańcuch znaków: “Hello ”. Oto treść tego znacznika:

Treść takiego procesora metadata tagów była by następująca:

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

Aby można było go używać należy go dodać do kompilatora w ten sposób:

	$viewCompiler->addTagProcessor('\HelloMetadataTag')

Od tej pory można już korzystać z metadata tagu `[Hello]`

**HelloComponent.nbml**

	<?php /**
	 * @var $this \Nbml\Component
	 *
	 * [Hello] @var $miwa string('Miwa')
	 */ ?>

	 <?=$miwa?>

Wywołanie tego komponentu:

	<?php
	echo new HelloComponent(); //Hello Miwa

Pisząc komponenty mamy dostęp do zmiennej `$this->variable` oraz `$this->definition`.
Zmienna `$this->variable` jest typu `\Nbml\Reflector\Variable` i jest w niej pełen opis
zmiennej do kórej dany metadata tag jest przypisany.

Natomiast zmienna `$this->definition`
jest definicją danego metadata tagu (w tym przypadku definicją meta tagu Hello).
Jest ona typu: \Nbml\Reflector\MetadataTagDefinition. W tym obiekcie znajdziemy
wszystkie dane o atrybutach (i ich wartościach) danego metadata tagu.

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
Pisząc komponenty interpreter nadpisuje funkcję `__invoke()`, a rolą funkcji __invoke()
jest zapełnienie zmiennej `$this->text`.

Pozostaje mi już tylko pozostawić ciebie twojej wyobraźni:)
