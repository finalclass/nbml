# Jak to działa? [how-does-it-work]

Koncepcja jest dość prosta. Piszemy pliki *.nbml które to są interpretowane do plików *.php. Konkretnie - do klas php.
Pliki *.nbml są zwykłymi plikami html z przeplatanym php, czyli standardowymi plikami szablonów php (często rozszerzeniem
takich plików jest *.phtml). Następnie tworzona jest z nich klasa.
Schematycznie można to pokazać w ten sposób:

Załóżmy, że mamy taki oto plik *.nbml:

  <?php /**
   * @var $this \Nbml\Component
   */ ?>
   Example component

Umieśćmy go w folderze MyNamespace\Example i nazwijmy Example.nbml (plik będzie tutaj: /MyNamespace/Example/Example.nbml)

Teraz gdzieś w pliku *.php wykonajmy następujące polecenie:

  <?php
  $exampleComponent = new \MyNamespace\Example();
  echo $exampleComponent

W momencie użycia klasy \MyNamespace\Example zostanie pobrany plik MyNamespace/Example/Example.nbml, skompilowany do klasy
\MyNamespace\Example oraz dołączony (require_once).

**Schematycznie** treść wygenerowanego pliku php będzie następująca:

	<?php
	namespace MyNamespace;
	class Example extends \Nbml\Component
	{

	  public function __toString()
	  {
	    ?>
	    <?php /**
         * @var $this \Nbml\Component
         */ ?>
         Example component

     <?php
	  }
	}

Oczywiście jest to tylko schemat działania, jeśli jesteś zainteresowany konkretną kompilacją, po prostu zobacz jak plik
Example.php wygląda w rzeczywistości.
