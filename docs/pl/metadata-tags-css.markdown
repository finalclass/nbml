# Metadata Tags - Css [metadata-tags-css]

Metadata tag [\[Css\]][metadata-tags-css] służy do ładowania plików css.
Nbml dostarcza podstawową
wersję komponentu który jest dokumentem html: `\Nbml\Component\Application`.
Można tę wersję rozbudować według własnych potrzeb. Należy zwrócić uwagę, że
nbml nie umożliwia ręcznego umieszczania plików css i js (można to zrobić jednak
nie jest to wskazane). Zamiast tego zaleca się tworzenie głównego komponentu tak
aby dziedziczył po `\Nbml\Component\Application`. Komponent Application posiada
zmienną styleSheets która to jest typu `\Nbml\Collection`. Można do niej dodawać
pliki styli na przykład w ten sposób:

	\Nbml\Component\Application::getInstance()->styleSheets()->add('/css/styles.css')

Dokładnie taką operację wykonuje znacznik [\[Css\]][metadata-tags-css]. Jako, że `Application::getInstance()`
zwraca zawsze ostatnio utworzoną instancję (za pomocą `new`) to w momencie
tworzenia mamy właśnie do niej dostęp. W systemie nie powinna być tworzona
kolejna instancja Application. Wysyłamy do klienta tylko jedną strone html!
Oczywiście mogą się pojawić wyjątki (chociaż ciężko mi wymyśleć jakieś).
W takim przypadku należy pamiętać o tym, że `Application::getInstance()`
zwraca zawsze ostatnio utworzoną instancję.

## Atrybuty

Znacznik [\[Css\]][metadata-tags-css] posiada jeden atrybut: file.
Jest on atrybutem domyślnym, zatem konstrukcja `[Css(file="/css/styles.css")]`
jest jednoznaczna z `[Css("/css/styles.css")]`

## Ścieżki względne

Znacznik [\[Css\]][metadata-tags-css] umożliwia wprowadzanie ścieżek względnych.
Gdy, dla przykładu, tworzymy plik podając ścieżke względną do pliku css:

**public/Example/MyComponent/MyComponent.nbml**

	<?php /**
	 * [Css('myComponent.css')]
	 * @var $this \Nbml\Component
	 */ ?>
	Component content...

to ścieżka względna zostanie rozwinięta w ten sposób:
`<link href="/Example/MyComponent/myComponent.css" .../>`

Gdy zdefiniujemy ścieżkę jako ścieżkę bezwzględną: `[Css('/myComponent.css')]`
to zostanie ona niezmieniona: `<link href="/myComponent.css" .../>`.

W przypadku pracyz plikami zdalnymi należy pamiętać o wstawieniu http lub https
przy definiowaniu lokalizacji pliku css tak aby ścieżka nie została rozwinięta
do ścieżki bezwzględnej - system musi wiedzieć, że chodzi o plik zdalny.
Dla przykładu ścieżka tego typu: `[Css('example.com/file.css')]` użyta w powyższym
komponencie zostanie rozwinięta do:  `/Example/MyComponent/example.com/file.css.`
Poprawną formą powinno być podanie __http__ na początku w ten sposób:
`[Css('http://example.com/file.css')]`

Ta sama zasada tyczy się znacznika [\[Js\]][metadata-tags-js]

## Przypisanie znacznika do zmiennej

Ten znacznik nie jest związany z zmienną do której jest przypisany jednak
powinien być przypisany do jakiejś zmiennej.

Poniżej znajduje się błędna konstrukcja:

**Błędny plik!!!**

	<?php /**
	 * @var $this \Nbml\Component\Application
	 *
	 * [Css('/css/styles.css')]
	 */ ?>
	 Component content...

Poprawnie ten komponent powinien być zbudowany w ten sposób:

	<?php /**
	 * [Css('/css/styles.css')]
	 * @var $this \Nbml\Component\Application
	 */ ?>
	 Component content...

Czyli metadata tag [\[Css\]][metadata-tags-css] powinien być przypisany do jakiejś zmiennej.
Najlepiej przypisać tego typu metadata tagi do zmiennej $this. Jest to metoda zalecana.
Podobnie działa metadata tag [\[Js\]][metadata-tags-js].