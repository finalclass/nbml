# Metadata Tags - State [metadata-tags-state]

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
