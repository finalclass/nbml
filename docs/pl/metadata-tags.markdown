# Metadata Tags [metadata-tags]

Nbml wykorzystuje phpdoc do definiowania obiektów. Przykładowo taka konstrukcja:

	<?php /**
	 * @var $this \Nbml\Component
	 * @var $message string
	 */ ?>

utworzy klasę dziedziczącą po \Nbml\Component z prywatną zmienną $message o typie string. W ten sposób możemy definiować pewne aspekty budowanego komponentu.
Nbml posiada również mechanizm definiowania własnych tagów, które to zmieniają właściwości definiowanej zmiennej.
W bibliotece standardowej mamy do dyspozycji następujące tagi: [\[Public\]][metadata-tags-public],
[\[State\]][metadata-tags-state], [\[OnState\]][metadata-tags-on-state],
[\[OnDemand\]][metadata-tags-on-demand], [\[Css\]][metadata-tags-css] oraz [\[Js\]][metadata-tags-js].

### Atrybuty Metadata tagów

Metadata tagi mogą przyjmować pewne atrybuty. Jeżeli dany Metatag przyjmuje atrybuty może
on również mieć zdefiniowany atrybut domyślny. Dla przykładu atrybut `\[OnState\]` może być parametryzowany
przez atrybut `name` który to jest atrybutem domyślnym. Zatem zapis:

	* [OnState(name='selected')]

jest równoznaczny z zapisem:

	* [OnState('selected')]

W przypadku gdy metadata tag przyjmuje więcej atrybutów ich nazwy powinny być oddzielone przecinkami w ten sposób:

	* [Tag(attr1='value1', attr2='value2', attr3='value3')]

Interpreter umożliwia również prostę tworzenie własnych Metadata tagów.
Proces ten opisany jest w tym miejscu [Własne Metadata tagi][custom-metadata-tags]