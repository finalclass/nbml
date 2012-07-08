# Metadata Tags - OnState [metadata-tags-on-state]

Ustawienie na pewnym komponencie metatagu [\[OnState\]][metadata-tags-on-state]
powoduje ustawienie warunku na danej zmiennej.
**Zmienna zostanie zainicjalizowana tylko w przypadku gdy komponent znajdujować się będzie w zadanym stanie.**
W przeciwnym wypadku jej wartość będzie pustym łańcuchem znaków.

Metadata tag [\[OnState\]][metadata-tags-on-state]
przyjmuje jeden argument `name` określający nazwę stanu w którym dana
zmienna ma się zainicjalizować. Argument `name` jest argumentem domyślnym więc nie
ma konieczności pisać `[OnState(name='stateName')]`, można skorzystać ze skróconej
formy: `[OnState('stateName')]`.

Rozpatrzmy przypadek przycisku:

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

Powyższy przycisk będzie miał klasę `selected` **tylko** w przypadku gdy komponent Button będzie
w stanie selectedState.

Tę właściwość można łatwo połączyć z właściwością [\[Public\]][metadata-tags-public] i stworzyć
customizowalny przycisk w ten sposób:

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

W tym przypadku sami możemy określić jaka klasa powinna być użyta dla stanu `selectedState`.
