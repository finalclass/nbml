# Metadata Tags - Public [metadata-tags-public]

Rozpatrzmy poniższy przykład:

**plik HelloWorld.nbml**

	<?php /**
	 * @var $this \Nbml\Component
	 *
	 * [Public] @var $message string('Hello World!')
	 */ ?>
	 <div class="center bold">
	  <?=$message?>
	 </div>

A następnie jego użycie:

	<?php
	$helloComponent = new HelloWorld();
	echo $helloWorld->message(); //Hello World!
	$helloComponent->message('Hello Internet!');
	echo $helloComponent->message(); //Hello Internet!
	echo $helloComponent; //<div class..../>

Użycie Metadata tagu \[Public\] powoduje utworzenie publicznego gettera oraz settera dla zmiennej
prywatnej $message.