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
