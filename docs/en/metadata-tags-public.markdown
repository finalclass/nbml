# Metadata Tags - Public [metadata-tags-public]

Let's consider following example:

**file HelloWorld.nbml**

	<?php /**
	 * @var $this \Nbml\Component
	 *
	 * [Public] @var $message string('Hello World!')
	 */ ?>
	 <div class="center bold">
	  <?=$message?>
	 </div>

And then its usage:

	<?php
	$helloComponent = new HelloWorld();
	echo $helloComponent->message(); //Hello World!
	$helloComponent->message('Hello Internet!');
	echo $helloComponent->message(); //Hello Internet!
	echo $helloComponent; //<div class..../>

Using of the Metadata tag \[Public\] shall cause creating a public getter and setter for private variable $message.
