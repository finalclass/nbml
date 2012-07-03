# NetBricks Markup Language [welcome]

Nbml jest językiem służącym do definiowania widoków w sposób obiektowy. Za jego pomocą w łatwy sposób możemy przekształcić widok w formacie phtml (html ze wstawkami w języku php), do klas php.

Szymon Wygnański

# Wymagania systemowe [system-requirements]

Biblioteka nbml wymaga php w wersji minimum 5.3

# Tworzenie instancji [instantiation]

Aby rozpocząć pracę z plikami nbml należy zainicjalizować ViewAutoLoader. Klasa ta rejestruje php autoloader
tak aby obsługiwał plik *.nbml. Można to zrobić korzystająć z dostarczonego sandboxa lub manualnie.
Należy również zainicjalizować jakiś autoloader do klas biblioteki Nbml, ponieważ Nbml korzysta ze standardowego
 sposobu ładowania klas, ta czynność jest pozostawiona programiście. Przejdźmy najpierw jednak do prostszego
 rozpoczęcia pracy z wykorzystaniem pliku sandbox [instantiation-sandbox].

## Sandbox [instantiation-sandbox]

Jest to najprostsza i zarazem najmniej elastyczna forma zainicjalizowania nbmla.

	$viewAutoLoader = include 'library/Nbml/sandbox_runtime.php';

## Manual [instatiation-manual]

## Composer [instantiation-composer]

