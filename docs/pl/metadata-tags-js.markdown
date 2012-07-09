# Metadata Tags - Js [metadata-tags-js]

Działanie znacznika [\[Js\]][metadata-tags-js] jest identyczne z działaniem znacznika
[\[Css\]][metadata-tags-css] z tą różnicą, że odpowiada on za dodawanie plików JavaScript.
Powoduje on dodanie następującej linijki w konstruktorze komponentu:

	\Nbml\Component\Application::getInstance()->scripts()->add('file.js');

