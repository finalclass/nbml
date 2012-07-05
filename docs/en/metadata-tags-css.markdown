# Metadata Tags - Css [metadata-tags-css]

Metadata tag [\[Css\]][metadata-tags-css] is used to load CSS files.
The nbml provides basic
version of the component, which actually is an HTML `\Nbml\Component\Application`.
This version can be extended with your own needs. Take notice that nmbl does not allow to put css and js files manually (it can be done, but is not recommended). Instead, it is recommended to create main component such way, that it can inherit from `\Nbml\Component\Application`. The Application component has variable styleSheets which is of type `\Nbml\Collection`. The style files can be added to it for example in this manner:

	\Nbml\Component\Application::getInstance()->styleSheets()->add('/css/styles.css')

Exactly this operation is done by tag [\[Css\]][metadata-tags-css]. Inasmuch `Application::getInstance()` returns always the last created instance (with `new`), in the moment of creating we have access exactly to it. In the system there shouldn't be created another instance of Application. We send to client just one HTML site!
Sure, there can be exceptions (but it's hard to me to figure out any).
In such case it should be kept in mind, that `Application::getInstance()`
always returns the last created instance.

## Attributes

Tag [\[Css\]][metadata-tags-css] has one attribute: file.
It is default attribute, so construction `[Css(file="/css/styles.css")]`
is equal with `[Css("/css/styles.css")]`

## Relative paths

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

## Assigning tag to variable

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
