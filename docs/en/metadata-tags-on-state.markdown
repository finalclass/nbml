# Metadata Tags - OnState [metadata-tags-on-state]

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
