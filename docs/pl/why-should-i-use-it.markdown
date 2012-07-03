# Dlaczego warto używać nbml? [why-should-i-use-it]

Php jest językiem który sam w sobie jest systemem szablonów. Pisanie stron internetowych wykorzystując czysty
html+js+css jest najlepszym rozwiązaniem. Problem polega na tym, że gdy odseparujesz widok od konktrolera w php
to widoki nie są konkretne. To znaczy nie wiadomo jakie zmienne może dany szablon przyjmować.
IDE nie jest w stanie podpowiedzieć co można w danym szablonie wykonać. Koder nie wiem jakie zmienne
programista zostawił mu do dyspozycji.

Z pomocą przychodzi nbml. Dzięki niemu dalej tworzymy szablony w html+php jednak tym razem kontrakt pomiędzy
koderem a programistą jest jasny. Koder wie co ma do dyspozycji w danymi widoku a programista jest szczęśliwy bo
ma obiekt:) Nikt nie pomyli się w nazewnictwie zmiennych gdyż IDE bez problemu parsuje wygenerowane klasy
i podpowieada dostępne opcję jak i typy zmiennych.

Dzięki temu rozwiązaniu posiadasz w pełni **obiektowy widok**. Tworzysz drzewo lekkich komponentów. Tworzysz je jednak
w htmlu - skinownanie jest załatwione.

To rozwiązanie jest kompletnie nieinwazyjne i można bez szadnych przeciwskazań korzystać z nbmla równolegle
z innymi bibliotekami.