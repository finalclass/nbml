# Metadata Tags - OnDemand [metadata-tags-on-demand]

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
