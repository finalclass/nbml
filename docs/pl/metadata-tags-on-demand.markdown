# Metadata Tags - OnDemand [metadata-tags-on-demand]

Ten znacznik powoduje utworzenie w miejsce zadanej zmiennej obiektu
`\Nbml\MetadataTag\OnDemandMetadataTag\OnDemandFactory`.
Powyższa klasa tworzy zadaną zmienną w momencie jej użycia
(w momencie wywołania metod: `__toString()`, `__invoke()`,
`__call()`, `__set()` lub `__get()`)

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

W powyższym przykładzie w miejsce $subComponent zostaje utworzona klasa OnDemandFactory
a następnie (tylko gdy rand(0, 9) > 4) OnDemandFactory w momencie __toString()
tworzy obiekt klasy \Nbml\Component jak to było zadane w phpDoc.

Powyższy przykład ma za cel zaprezentowanie koncepcji działania znacznika \[OnDemand\]
jest on jednak bezużyteczny. \[OnDemand\] sprawdza się idealnie przy "ciężkich" komponentach
których inicjalizacja wiąże się z dużym obciążeniem systemu.