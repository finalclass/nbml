# Metadata Tags - State [metadata-tags-state]

Metadata tag \[State\] powoduje dodanie stanu do danego komponentu. Zmienne zdefiniowane jako
\[State\] powinny być typu boolean.
Włączenie jednego stanu powoduje wyłączenie innych.

Rozpatrzmy poniższy przykładowy komponent przycisku:

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

a następnie jego użycie:

	<?php

	$button = new Button();
	var_dump($button->normalState()); //true
	$button->selectedState(true);
	var_dump($button->normalState()); //false
	echo $button;

ustawienie zmiennej selectedState na true powoduje ustawienie innych zmiennych stanowych na false.
Często korzysta się z metatagu \[State\] we współpracy z metatagiem [\[OnState\]][metadata-tags-on-state]